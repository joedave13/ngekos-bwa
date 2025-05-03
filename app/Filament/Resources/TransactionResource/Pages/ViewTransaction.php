<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('warning')
                ->icon('heroicon-m-pencil'),
        ];
    }

    public function  infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('created_at')
                ->label('Transaction Date')
                ->dateTime('d M Y H:i:s'),
            TextEntry::make('code'),
            Section::make('Customer Information')
                ->description('Information about customer')
                ->icon('heroicon-m-user')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')
                        ->columnSpanFull(),
                    TextEntry::make('email'),
                    TextEntry::make('phone'),
                ]),
            Section::make('Boarding House')
                ->description('Information about the boarding house')
                ->icon('heroicon-m-home-modern')
                ->columns(2)
                ->schema([
                    TextEntry::make('boardingHouse.name'),
                    TextEntry::make('boarding_house_price')
                        ->numeric(thousandsSeparator: '.')
                        ->prefix('IDR ')
                        ->label('Price'),
                    TextEntry::make('room.name'),
                    TextEntry::make('room_price')
                        ->numeric(thousandsSeparator: '.')
                        ->prefix('IDR ')
                        ->label('Price per Month'),
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('start_date')
                                ->date('d M Y')
                                ->label('Start Date'),
                            TextEntry::make('duration_in_month')
                                ->numeric()
                                ->label('Duration in Month'),
                            TextEntry::make('end_date')
                                ->date('d M Y')
                                ->label('End Date')
                        ])
                ]),
            Section::make('Payment Information')
                ->description('Information about the payment')
                ->icon('heroicon-m-credit-card')
                ->columns(2)
                ->schema([
                    TextEntry::make('sub_total')
                        ->numeric(thousandsSeparator: '.')
                        ->prefix('IDR ')
                        ->label('Sub Total'),
                    TextEntry::make('vat')
                        ->numeric(thousandsSeparator: '.')
                        ->prefix('IDR ')
                        ->label('VAT (11%)'),
                    TextEntry::make('insurance_amount')
                        ->numeric(thousandsSeparator: '.')
                        ->prefix('IDR ')
                        ->label('Insurance Amount'),
                    TextEntry::make('grand_total_amount')
                        ->numeric(thousandsSeparator: '.')
                        ->prefix('IDR ')
                        ->label('Grand Total Amount'),
                    TextEntry::make('payment_method')
                        ->badge()
                        ->color(fn($state) => $state->getColor())
                        ->label('Payment Method'),
                    TextEntry::make('payment_status')
                        ->badge()
                        ->color(fn($state) => $state->getColor())
                        ->label('Payment Status')
                ])
        ]);
    }
}
