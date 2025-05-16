<?php

namespace App\Filament\Resources\KeluargaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LahirsRelationManager extends RelationManager
{
    protected static string $relationship = 'lahirs';

    protected static ?string $title = 'Daftar Kelahiran'; // Optional: Set the default title for the tab
    protected static ?string $icon = 'tabler-diaper'; // Optional: Set the default title for the tab

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->lahirs->count();
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
                    ->label('Keluarga Sebelumnya'),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable()
                    ->label('NIK'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('keluarga.alamat')
                    ->label('Alamat'),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date('D, d F Y'),
                Tables\Columns\TextColumn::make('tempat_lahir'),
                Tables\Columns\TextColumn::make('orang_tua')
                    ->default(
                        function($record) {
                            $ortus = [];

                            foreach($record->anggotas as $agg){
                                $ortus[] = $agg->nama . " (". $agg->tipe_pasangan .")";
                            }

                            return implode(" , ", $ortus);
                        }
                    )
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
