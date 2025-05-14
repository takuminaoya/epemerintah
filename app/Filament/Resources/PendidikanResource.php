<?php

namespace App\Filament\Resources;

use App\Base\MasterForm;
use App\Filament\Imports\PendidikanImporter;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pendidikan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PendidikanResource\Pages;
use App\Filament\Resources\PendidikanResource\RelationManagers;

class PendidikanResource extends Resource
{
    protected static ?string $modelLabel = 'pendidikan';
    protected static ?string $pluralModelLabel = 'pendidikan';

    protected static ?string $model = Pendidikan::class;

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
                ImportAction::make('import pendidikan')
                    ->importer(PendidikanImporter::class)
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePendidikans::route('/'),
        ];
    }
}
