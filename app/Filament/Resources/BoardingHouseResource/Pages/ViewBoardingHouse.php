<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use Filament\Actions;
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
}
