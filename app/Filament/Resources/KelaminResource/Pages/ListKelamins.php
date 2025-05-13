<?php

namespace App\Filament\Resources\KelaminResource\Pages;

use App\Filament\Resources\KelaminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelamins extends ListRecords
{
    protected static string $resource = KelaminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
