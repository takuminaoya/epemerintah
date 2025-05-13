<?php

namespace App\Filament\Resources;

use App\Filament\Imports\StatusPernikahanImporter;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StatusPernikahan;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StatusPernikahanResource\Pages;
use App\Filament\Resources\StatusPernikahanResource\RelationManagers;

class StatusPernikahanResource extends Resource
{
    protected static ?string $modelLabel = 'status pernikahan';
    protected static ?string $pluralModelLabel = 'status pernikahan';

    protected static ?string $model = StatusPernikahan::class;

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
                    ->label('Dibuat pada')
                    ->since()
                    ->dateTimeTooltip()
            ])
            ->headerActions([
                ImportAction::make('import status nikah')
                    ->importer(StatusPernikahanImporter::class)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            'index' => Pages\ListStatusPernikahans::route('/'),
            'create' => Pages\CreateStatusPernikahan::route('/create'),
            'edit' => Pages\EditStatusPernikahan::route('/{record}/edit'),
        ];
    }
}
