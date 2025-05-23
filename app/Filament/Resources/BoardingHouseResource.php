<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-s-home-modern';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('category:id,name');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Information')
                    ->columns(2)
                    ->description('General information about the boarding house')
                    ->icon('heroicon-s-home-modern')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state) . '-' . strtolower(Str::random(6)))),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->readOnly(),
                                Forms\Components\Toggle::make('is_popular')
                                    ->default(false)
                                    ->inline(false)
                                    ->label('Is Popular?')
                            ]),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),
                            ]),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->columnSpanFull()
                            ->directory('boarding-houses'),
                        Forms\Components\RichEditor::make('description'),
                        Forms\Components\RichEditor::make('address'),
                    ]),
                Section::make("Boarding House's Image")
                    ->description('Images of the boarding house')
                    ->icon('heroicon-s-photo')
                    ->schema([
                        Repeater::make('boardingHouseImages')
                            ->relationship()
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('boarding-houses/images')
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular()
                    ->alignment(Alignment::Center)
                    ->defaultImageUrl('https://placehold.co/400'),
                Tables\Columns\TextColumn::make('name')
                    ->description(fn(BoardingHouse $record) => $record->category->name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->prefix('IDR ')
                    ->sortable()
                    ->label('Price per Month'),
                Tables\Columns\ToggleColumn::make('is_popular')
                    ->label('Is Popular?'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'view' => Pages\ViewBoardingHouse::route('/{record}'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
