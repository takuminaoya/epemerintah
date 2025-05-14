<?php

namespace App\Filament\Resources;

use App\Base\MasterForm;
use App\Filament\Resources\KelaminResource\Pages;
use App\Filament\Resources\KelaminResource\RelationManagers;
use App\Models\Kelamin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelaminResource extends Resource
{
    protected static ?string $modelLabel = 'jenis kelamin';
    protected static ?string $pluralModelLabel = 'jenis kelamin';

    protected static ?string $model = Kelamin::class;

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
            'index' => Pages\ListKelamins::route('/'),
            'create' => Pages\CreateKelamin::route('/create'),
            'edit' => Pages\EditKelamin::route('/{record}/edit'),
        ];
    }
}
