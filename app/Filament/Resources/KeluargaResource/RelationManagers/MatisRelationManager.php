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

class MatisRelationManager extends RelationManager
{
    protected static string $relationship = 'matis';

    protected static ?string $title = 'Daftar Kematian'; // Optional: Set the default title for the tab
    protected static ?string $icon = 'heroicon-o-x-mark'; // Optional: Set the default title for the tab

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->matis->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->description('Daftar catatan resmi yang memuat informasi tentang orang-orang yang telah meninggal dunia dalam suatu wilayah atau komunitas tertentu.')
            ->recordTitleAttribute('keluarga_id')
            ->columns([
                Tables\Columns\TextColumn::make('keluarga.nomor')
                    ->label('Nomor KK'),
                Tables\Columns\TextColumn::make('penduduk.nik')
                    ->searchable()
                    ->label('NIK'),
                Tables\Columns\TextColumn::make('penduduk.nama')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('penduduk.alamat')
                    ->label('Alamat Sebelumnya'),
                Tables\Columns\TextColumn::make('meninggal_pada')
                    ->date('D, d F Y'),
                Tables\Columns\TextColumn::make('tempat_meninggal'),
                Tables\Columns\TextColumn::make('penyebab_kematian')
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
