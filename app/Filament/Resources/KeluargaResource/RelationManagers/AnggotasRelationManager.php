<?php

namespace App\Filament\Resources\KeluargaResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AnggotasRelationManager extends RelationManager
{
    protected static string $relationship = 'anggotas';

    protected static ?string $title = 'Daftar Anggota Keluarga'; // Optional: Set the default title for the tab
    protected static ?string $icon = 'heroicon-o-user-group'; // Optional: Set the default title for the tab

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->anggotas->count();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->description('Dokumen atau catatan yang memuat informasi mengenai orang-orang yang termasuk dalam satu keluarga atau rumah tangga.')
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nik')
                    ->searchable(),
                TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->label("Tempat/Tanggal Lahir")
                    ->date()
                    ->description(fn(Penduduk $record): string => $record->tempat_lahir, position: 'above'),
                TextColumn::make('posisi_keluarga.nama')
                    ->sortable(),
                TextColumn::make('kelamin.nama'),
                TextColumn::make('alamat'),
                TextColumn::make('agama.nama'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'tidak aktif' => 'danger',
                        'pindah' => 'warning',
                        'meninggal' => 'danger',
                        'lahir' => 'primary',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([]);
    }
}
