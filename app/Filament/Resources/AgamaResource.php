<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Agama;
use App\Base\MasterForm;
use App\Filament\Imports\AgamaImporter;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AgamaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AgamaResource\RelationManagers;

class AgamaResource extends Resource
{
    protected static ?string $modelLabel = 'Agama';
    protected static ?string $pluralModelLabel = 'Agama';
    protected static ?string $navigationGroup = 'Master';

    protected static ?string $model = Agama::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(MasterForm::basic_form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(MasterForm::basic_column())
            ->filters([
                //
            ])
            ->headerActions([
                ImportAction::make('import Agama')
                    ->importer(AgamaImporter::class)
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
            'index' => Pages\ManageAgamas::route('/'),
        ];
    }
}
