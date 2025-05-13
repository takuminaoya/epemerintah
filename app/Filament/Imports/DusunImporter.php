<?php

namespace App\Filament\Imports;

use App\Models\Dusun;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DusunImporter extends Importer
{
    protected static ?string $model = Dusun::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kode')
                ->requiredMapping()
                ->rules(['required', 'max:10']),
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('deskripsi')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('telp')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Dusun
    {
        // return Dusun::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Dusun();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your dusun import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
