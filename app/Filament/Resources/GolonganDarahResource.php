<?php

namespace App\Filament\Resources;

use App\Base\MasterForm;
use App\Filament\Imports\GolonganDarahImporter;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\GolonganDarah;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GolonganDarahResource\Pages;
use App\Filament\Resources\GolonganDarahResource\RelationManagers;

class GolonganDarahResource extends Resource
{
    protected static ?string $model = GolonganDarah::class;

    protected static ?string $modelLabel = 'Golongan Darah';
    protected static ?string $pluralModelLabel = 'Golongan Darah';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(MasterForm::basic_form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(MasterForm::basic_column())
            ->headerActions([
                ImportAction::make('import gol darah')
                    ->importer(GolonganDarahImporter::class)
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
            'index' => Pages\ListGolonganDarahs::route('/'),
            'create' => Pages\CreateGolonganDarah::route('/create'),
            'edit' => Pages\EditGolonganDarah::route('/{record}/edit'),
        ];
    }
}
