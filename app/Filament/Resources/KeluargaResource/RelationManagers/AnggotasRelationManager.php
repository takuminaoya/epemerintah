<?php

namespace App\Filament\Resources\KeluargaResource\RelationManagers;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AnggotasRelationManager extends RelationManager
{
    protected static string $relationship = 'anggotas';

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
            ->recordTitleAttribute('nama')
            ->modelLabel('Daftar Anggota Keluarga')
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
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([]);
    }
}
