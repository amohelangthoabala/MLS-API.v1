<?php

namespace App\Filament\Resources\AirtimeVoucherResource\Pages;

use App\Filament\Resources\AirtimeVoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAirtimeVoucher extends EditRecord
{
    protected static string $resource = AirtimeVoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
