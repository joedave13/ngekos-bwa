<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewBoardingHouse extends ViewRecord
{
    protected static string $resource = BoardingHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('warning')
                ->icon('heroicon-m-pencil'),
            Actions\DeleteAction::make()
                ->icon('heroicon-m-trash'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('name'),
            TextEntry::make('slug'),
            Grid::make(3)->schema([
                TextEntry::make('city.name'),
                TextEntry::make('category.name'),
                TextEntry::make('price')->prefix('IDR '),
            ]),
            ImageEntry::make('thumbnail')
                ->size(250)
                ->columnSpanFull(),
            TextEntry::make('description')
                ->html(),
            TextEntry::make('address')
                ->html(),
        ]);
    }
}
