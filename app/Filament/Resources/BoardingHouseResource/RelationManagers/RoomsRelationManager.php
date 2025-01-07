<?php

namespace App\Filament\Resources\BoardingHouseResource\RelationManagers;

use App\Enums\RoomType;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('room_type')
                    ->required()
                    ->options(RoomType::class)
                    ->enum(RoomType::class)
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('square_feet')
                    ->required()
                    ->numeric()
                    ->label('Square Feet'),
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('boarding-houses/rooms')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price_per_month')
                    ->required()
                    ->numeric()
                    ->label('Price Per Month')
                    ->prefix('IDR'),
                Forms\Components\Toggle::make('is_available')
                    ->default(true)
                    ->inline(false)
                    ->label('Is Available?')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->width(120)
                    ->height(150)
                    ->extraImgAttributes([
                        'class' => 'rounded-md'
                    ]),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('room_type')
                    ->badge()
                    ->color(fn($state) => $state->getColor())
                    ->label('Room Type'),
                Tables\Columns\TextColumn::make('square_feet')
                    ->label('Square Feet')
                    ->description(fn(Room $record) => $record->capacity . ' people'),
                Tables\Columns\TextColumn::make('price_per_month')
                    ->prefix('IDR ')
                    ->numeric()
                    ->label('Price Per Month'),
                Tables\Columns\ToggleColumn::make('is_available')
                    ->label('Is Available?')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Room')
                    ->icon('heroicon-m-plus'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
