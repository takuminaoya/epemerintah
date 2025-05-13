<?php

namespace App\Filament\Resources\StatusPernikahanResource\Pages;

use App\Filament\Resources\StatusPernikahanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusPernikahans extends ListRecords
{
    protected static string $resource = StatusPernikahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
