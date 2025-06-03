<?php

namespace App\Filament\Resources\AirtimeVoucherResource\Pages;

use App\Filament\Resources\AirtimeVoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAirtimeVouchers extends ListRecords
{
    protected static string $resource = AirtimeVoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
