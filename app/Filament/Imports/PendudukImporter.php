<?php

namespace App\Filament\Imports;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Carbon\CarbonInterface;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Filament\Actions\Imports\Exceptions\RowImportFailedException;

class PendudukImporter extends Importer
{
    protected static ?string $model = Penduduk::class;

    public function getJobRetryUntil(): ?CarbonInterface
    {
        return null;
    }

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('uuid')
                ->label('penduduk_id')
                ->requiredMapping()
                ->rules(['required', 'max:36']),
            ImportColumn::make('kk')
                ->requiredMapping()
                ->rules(['required', 'max:16']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:16']),
            ImportColumn::make('nama')
                ->requiredMapping()
                ->label('nama_lengkap')
                ->rules(['required', 'max:255']),
            ImportColumn::make('tanggal_lahir')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('tempat_lahir')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('telp')
                ->label('telepon')
                ->rules(['max:255']),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('nik_ayah')
                ->requiredMapping()
                ->rules(['max:16']),
            ImportColumn::make('nama_ayah')
                ->label('nama_lengkap_ayah')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('nik_ibu')
                ->requiredMapping()
                ->rules(['max:16']),
            ImportColumn::make('nama_ibu')
                ->label('nama_lengkap_ibu')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('golongan_darah_id')
                ->label('blood_sid'),
            ImportColumn::make('status_pernikahan_id')
                ->label('marriage_sid'),
            ImportColumn::make('pendidikan_id')
                ->label('education_sid'),
            ImportColumn::make('pekerjaan_id')
                ->label('job_sid'),
            ImportColumn::make('posisi_keluarga_id')
                ->label('sif_sid'),
            ImportColumn::make('kelamin_id')
                ->label('gender_sid'),
            ImportColumn::make('agama_id')
                ->label('religion_sid'),
        ];
    }

    public function resolveRecord(): ?Penduduk
    {
        $nkk = str_replace("'", "", $this->data['kk']);
        $kk = Keluarga::where('nomor', $nkk)->first();

        if (!$kk) {
            throw new RowImportFailedException("No product found with SKU [{$this->data['kk']}].");
        }

        $f = Penduduk::create([
            "uuid" => $this->data['uuid'],
            "keluarga_id" => $kk->id,
            "nik" => str_replace("'", "", $this->data['nik']),
            "nama" => $this->data['nama'],
            "tanggal_lahir" => $this->data['tanggal_lahir'],
            "tempat_lahir" => $this->data['tempat_lahir'],
            "telp" => $this->data['telp'],
            "alamat" => $this->data['alamat'],
            "nik_ayah" => $this->data['nik_ayah'],
            "nama_ayah" => $this->data['nama_ayah'],
            "nik_ibu" => $this->data['nik_ibu'],
            "nama_ibu" => $this->data['nama_ibu'],

            "golongan_darah_id" => $this->data['golongan_darah_id'],
            "status_pernikahan_id" => $this->data['status_pernikahan_id'],
            "pendidikan_id" => $this->data['pendidikan_id'],
            "pekerjaan_id" => $this->data['pekerjaan_id'],
            "posisi_keluarga_id" => $this->data['posisi_keluarga_id'],
            "kelamin_id" => $this->data['kelamin_id'],
            "agama_id" => $this->data['agama_id'],
        ]);

        if (!$f) {
            throw new RowImportFailedException("Error " . $f);
        }

        return $f;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your penduduk import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
