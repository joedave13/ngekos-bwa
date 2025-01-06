<?php

namespace App\Filament\Resources\BoardingHouseResource\RelationManagers;

use App\Models\BoardingHouseImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class BoardingHouseImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'boardingHouseImages';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->image()
                    ->directory('boarding-houses/image')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image')
            ->columns([
                Tables\Columns\Layout\Grid::make()
                    ->columns(1)
                    ->schema([
                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\Layout\Grid::make()
                                ->columns(1)
                                ->schema([
                                    Tables\Columns\ImageColumn::make('image')
                                        ->height(150)
                                        ->width(120)
                                        ->extraImgAttributes([
                                            'class' => 'rounded-md'
                                        ]),
                                ])->grow(false),

                            Tables\Columns\Layout\Stack::make([
                                Tables\Columns\TextColumn::make('details_action_url')
                                    ->default(fn(BoardingHouseImage $record) => new HtmlString(
                                        Blade::render(
                                            '<x-filament::button color="info" icon="heroicon-m-eye" href="' . Storage::url($record->image) . '" tag="a" target="_blank">Detail</x-filament::button>'
                                        )
                                    ))
                            ])
                                ->extraAttributes(['class' => 'space-y-2'])
                                ->grow()
                        ])
                    ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3
            ])
            ->recordUrl(false)
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Boarding House Image')
                    ->icon('heroicon-m-plus'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
