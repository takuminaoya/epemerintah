<?php

namespace App\Filament\Imports;

use App\Models\Dusun;
use App\Models\Keluarga;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class KeluargaImporter extends Importer
{
    protected static ?string $model = Keluarga::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('uuid')
                ->label('UUID')
                ->requiredMapping()
                ->rules(['required', 'max:36']),
            ImportColumn::make('nomor')
                ->requiredMapping()
                ->rules(['required', 'max:16']),
            ImportColumn::make('nama_dusun')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->requiredMapping()
        ];
    }

    public function resolveRecord(): ?Keluarga
    {
        // return Keluarga::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return Keluarga::create([
            "uuid" => $this->data['uuid'],
            "nomor" => $this->data['nomor'],
            "nama_dusun" => $this->data['nama_dusun'],
            "alamat" => $this->data['alamat'],
            "dusun_id" => Dusun::where('nama', $this->data['nama_dusun'])->value('id'),
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your keluarga import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
