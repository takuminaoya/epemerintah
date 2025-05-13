<?php

namespace App\Filament\Resources\KelaminResource\Pages;

use App\Filament\Resources\KelaminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelamin extends EditRecord
{
    protected static string $resource = KelaminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
