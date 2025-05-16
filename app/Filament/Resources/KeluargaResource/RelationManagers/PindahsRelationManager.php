<?php

namespace App\Filament\Resources\KeluargaResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PindahsRelationManager extends RelationManager
{
    protected static string $relationship = 'pindah_anggotas';

    protected static ?string $title = 'Daftar Perpindahan'; // Optional: Set the default title for the tab
    protected static ?string $icon = 'heroicon-o-arrow-long-left'; // Optional: Set the default title for the tab

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->pindah_anggotas->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->description('Daftar proses perpindahan data atau perubahan status administrasi kependudukan seseorang atau sekelompok orang dari satu wilayah ke wilayah lain.')
            ->recordTitleAttribute('keluarga_id')
            ->columns([
                Tables\Columns\TextColumn::make('keluarga.nomor')
                    ->label('Keluarga Sebelumnya'),
                Tables\Columns\TextColumn::make('penduduk.nik')
                    ->searchable()
                    ->label('NIK'),
                Tables\Columns\TextColumn::make('penduduk.nama')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('penduduk.alamat')
                    ->label('Alamat Sebelumnya'),
                Tables\Columns\TextColumn::make('pindah.alasan_pindah'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
