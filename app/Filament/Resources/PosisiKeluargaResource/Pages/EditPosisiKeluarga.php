<?php

namespace App\Filament\Resources\PosisiKeluargaResource\Pages;

use App\Filament\Resources\PosisiKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosisiKeluarga extends EditRecord
{
    protected static string $resource = PosisiKeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
