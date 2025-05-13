<?php

namespace App\Filament\Resources;

use App\Filament\Imports\PekerjaanImporter;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pekerjaan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PekerjaanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PekerjaanResource\RelationManagers;

class PekerjaanResource extends Resource
{
    protected static ?string $modelLabel = 'pekerjaan';
    protected static ?string $pluralModelLabel = 'pekerjaan';

    protected static ?string $model = Pekerjaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
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
            ->filters([
                //
            ])
            ->headerActions([
                ImportAction::make('import pekerjaan')
                    ->importer(PekerjaanImporter::class)
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
            'index' => Pages\ListPekerjaans::route('/'),
            'create' => Pages\CreatePekerjaan::route('/create'),
            'edit' => Pages\EditPekerjaan::route('/{record}/edit'),
        ];
    }
}
