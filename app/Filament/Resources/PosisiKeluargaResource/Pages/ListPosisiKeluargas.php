<?php

namespace App\Filament\Resources\PosisiKeluargaResource\Pages;

use App\Filament\Resources\PosisiKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosisiKeluargas extends ListRecords
{
    protected static string $resource = PosisiKeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
