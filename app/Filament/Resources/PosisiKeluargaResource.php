<?php

namespace App\Filament\Resources;

use App\Filament\Imports\PosisiKeluargaImporter;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PosisiKeluarga;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PosisiKeluargaResource\Pages;
use App\Filament\Resources\PosisiKeluargaResource\RelationManagers;

class PosisiKeluargaResource extends Resource
{
    protected static ?string $model = PosisiKeluarga::class;

    protected static ?string $modelLabel = 'posisi dalam keluarga';
    protected static ?string $pluralModelLabel = 'posisi dalam keluarga';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->since()
                    ->dateTimeTooltip()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->headerActions([
                ImportAction::make('import posisi')
                    ->importer(PosisiKeluargaImporter::class)
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosisiKeluargas::route('/'),
            'create' => Pages\CreatePosisiKeluarga::route('/create'),
            'edit' => Pages\EditPosisiKeluarga::route('/{record}/edit'),
        ];
    }
}
