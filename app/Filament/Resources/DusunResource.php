<?php

namespace App\Filament\Resources;

use App\Filament\Imports\DusunImporter;
use Filament\Forms;
use Filament\Tables;
use App\Models\Dusun;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DusunResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DusunResource\RelationManagers;

class DusunResource extends Resource
{
    protected static ?string $modelLabel = 'Dusun/Banjar';
    protected static ?string $pluralModelLabel = 'Dusun/Banjar';

    protected static ?string $model = Dusun::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\TextInput::make('deskripsi')
                    ->required(),
                Forms\Components\TextInput::make('alamat')
                    ->required(),
                Forms\Components\TextInput::make('telp')
                    ->required()
                    ->prefix("+62")
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('nama')
                    ->description(fn(Dusun $record): string => $record->deskripsi),
                Tables\Columns\TextColumn::make('alamat'),
                Tables\Columns\TextColumn::make('telp')
                    ->copyable()
                    ->copyableState(fn(string $state): string => "+62{$state}")
                    ->copyMessage('no telpon copied')
                    ->copyMessageDuration(1500)
                    ->prefix("+62"),

            ])
            ->headerActions([
                ImportAction::make('import dusun')
                    ->importer(DusunImporter::class)
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
            'index' => Pages\ListDusuns::route('/'),
            'create' => Pages\CreateDusun::route('/create'),
            'edit' => Pages\EditDusun::route('/{record}/edit'),
        ];
    }
}
