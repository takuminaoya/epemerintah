<?php

namespace App\Filament\Resources\StatusPernikahanResource\Pages;

use App\Filament\Resources\StatusPernikahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusPernikahan extends EditRecord
{
    protected static string $resource = StatusPernikahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
