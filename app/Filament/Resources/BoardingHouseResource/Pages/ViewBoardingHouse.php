<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use App\Filament\Resources\BoardingHouseResource\RelationManagers\BoardingHouseImagesRelationManager;
use App\Filament\Resources\BoardingHouseResource\RelationManagers\FacilitiesRelationManager;
use App\Filament\Resources\BoardingHouseResource\RelationManagers\RoomsRelationManager;
use App\Filament\Resources\BoardingHouseResource\RelationManagers\TestimonialsRelationManager;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
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
            Section::make('General Information')
                ->columns(2)
                ->description('General information about the boarding house')
                ->icon('heroicon-s-home-modern')
                ->schema([
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
                ])
        ]);
    }

    public function getRelationManagers(): array
    {
        return [
            BoardingHouseImagesRelationManager::class,
            FacilitiesRelationManager::class,
            RoomsRelationManager::class,
            TestimonialsRelationManager::class
        ];
    }
}
