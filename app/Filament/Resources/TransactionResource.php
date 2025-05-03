<?php

namespace App\Filament\Resources;

use App\Enums\TransactionPaymentMethod;
use App\Enums\TransactionPaymentStatus;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-cart';

    protected static ?string $navigationGroup = 'Transaction';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->default('TRX' . Carbon::now()->format('ymd') . strtoupper(Str::random(5)))
                    ->readOnly(),
                Section::make('Customer Information')
                    ->description('Information about customer')
                    ->icon('heroicon-m-user')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-user'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-at-symbol'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->prefixIcon('heroicon-m-phone'),
                    ]),
                Section::make('Boarding House')
                    ->description('Information about the boarding house')
                    ->icon('heroicon-m-home-modern')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('boarding_house_id')
                            ->required()
                            ->live()
                            ->label('Boarding House')
                            ->options(BoardingHouse::query()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(function ($state, Set $set) {
                                $boardingHouse = BoardingHouse::query()->find($state);

                                $set('room_id', null);
                                $set('room_price', 0);
                                $set('boarding_house_price', $boardingHouse->price);
                            }),
                        Forms\Components\TextInput::make('boarding_house_price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR')
                            ->label('Boarding House Price')
                            ->readOnly()
                            ->default(0),
                        Forms\Components\Select::make('room_id')
                            ->live()
                            ->required()
                            ->label('Room')
                            ->searchable()
                            ->placeholder(fn(Get $get) => empty($get('boarding_house_id')) ? 'First select a boarding house' : 'Select a room')
                            ->options(function (Get $get) {
                                return Room::query()->where('boarding_house_id', $get('boarding_house_id'))->where('is_available', true)->pluck('name', 'id');
                            })
                            ->afterStateUpdated(function ($state, Set $set) {
                                $room = Room::query()->find($state);

                                $set('room_price', $room->price_per_month);
                            }),
                        Forms\Components\TextInput::make('room_price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR')
                            ->label('Room Price (Per Month)')
                            ->readOnly()
                            ->default(0),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->required()
                                    ->label('Start Date')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $durationInMonth = $get('duration_in_month');

                                        if ($state && $durationInMonth) {
                                            $endDate = Carbon::parse($state)->addMonths((int) $durationInMonth);
                                            $set('end_date', $endDate->toDateString());
                                        }
                                    }),
                                Forms\Components\TextInput::make('duration_in_month')
                                    ->required()
                                    ->numeric()
                                    ->label('Duration in Month')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $startDate = $get('start_date');

                                        if ($state && $startDate) {
                                            $endDate = Carbon::parse($startDate)->addMonths((int) $state);
                                            $set('end_date', $endDate->toDateString());
                                        }

                                        $room = Room::with(['boardingHouse'])->find($get('room_id'));

                                        $subTotalAmount = $room->boardingHouse->price + ($room->price_per_month * $state);
                                        $vatAmount = 0.11 * $subTotalAmount;

                                        $set('sub_total', $subTotalAmount);
                                        $set('vat', $vatAmount);
                                    }),
                                Forms\Components\DatePicker::make('end_date')
                                    ->required()
                                    ->label('End Date')
                                    ->readOnly(),
                            ]),
                    ]),
                Section::make('Payment Information')
                    ->description('Information about the payment')
                    ->icon('heroicon-m-credit-card')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('sub_total')
                            ->required()
                            ->numeric()
                            ->readOnly()
                            ->prefix('IDR')
                            ->label('Sub Total')
                            ->default(0),
                        Forms\Components\TextInput::make('vat')
                            ->required()
                            ->numeric()
                            ->readOnly()
                            ->prefix('IDR')
                            ->label('VAT (11%)')
                            ->default(0),
                        Forms\Components\TextInput::make('insurance_amount')
                            ->required()
                            ->numeric()
                            ->prefix('IDR')
                            ->label('Insurance Amount')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $grandTotalAmount = $get('sub_total') + $get('vat') + $state;

                                $set('grand_total_amount', $grandTotalAmount);
                            })
                            ->default(0),
                        Forms\Components\TextInput::make('grand_total_amount')
                            ->required()
                            ->numeric()
                            ->readOnly()
                            ->prefix('IDR')
                            ->label('Grand Total Amount')
                            ->default(0),
                        Forms\Components\Select::make('payment_method')
                            ->required()
                            ->label('Payment Method')
                            ->enum(TransactionPaymentMethod::class)
                            ->options(TransactionPaymentMethod::class)
                            ->native(false),
                        Forms\Components\Select::make('payment_status')
                            ->required()
                            ->default('pending')
                            ->label('Payment Status')
                            ->enum(TransactionPaymentStatus::class)
                            ->options(TransactionPaymentStatus::class)
                            ->native(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Transaction Date'),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->description(fn(Transaction $record) => $record->phone)
                    ->searchable(),
                Tables\Columns\TextColumn::make('boardingHouse.name')
                    ->description(fn(Transaction $record) => $record->room->name)
                    ->numeric()
                    ->sortable()
                    ->label('Boarding House'),
                Tables\Columns\TextColumn::make('date_duration')
                    ->sortable()
                    ->state(function (Transaction $record) {
                        return $record->start_date->format('d M Y') . ' - ' . $record->end_date->format('d M Y');
                    })
                    ->label('Date Duration'),
                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->numeric(thousandsSeparator: '.')
                    ->sortable()
                    ->prefix('IDR ')
                    ->label('Grand Total Amount'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable()
                    ->badge()
                    ->color(fn($state) => $state->getColor())
                    ->label('Payment Method'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable()
                    ->badge()
                    ->color(fn($state) => $state->getColor())
                    ->label('Payment Status'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        Tables\Actions\ViewAction::make()
                            ->color('info'),
                        Tables\Actions\EditAction::make()
                            ->color('warning'),
                    ])
                        ->dropdown(false),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('heroicon-m-bars-3')
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
