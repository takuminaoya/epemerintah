<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Keluarga;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Imports\KeluargaImporter;
use Filament\Forms\Components\Wizard\Step;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\KeluargaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KeluargaResource\RelationManagers;
use App\Filament\Resources\KeluargaResource\RelationManagers\AnggotasRelationManager;

class KeluargaResource extends Resource
{
    protected static ?string $model = Keluarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Kependudukan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anggotas_count')
                    ->label("Jumlah Anggota keluarga")
                    ->suffix(" Orang")
                    ->counts('anggotas'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'tidak aktif' => 'danger',
                    }),
            ])
            ->headerActions([
                ImportAction::make('import Keluarga')
                    ->importer(KeluargaImporter::class)
            ])
            ->filters([
                SelectFilter::make('dusun')
                    ->relationship('dusun', 'nama'),
                SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Masih Aktif',
                        'tidak aktif' => 'Sudah Tidak Aktif',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Detail Keluarga')
                    ->description('Detail keluarga secara singkat merujuk pada informasi dasar mengenai anggota dan struktur suatu keluarga.')
                    ->icon('heroicon-m-users')
                    ->collapsible()
                    ->persistCollapsed()
                    ->columns(4)
                    ->schema([
                        TextEntry::make('nomor')
                            ->label('Nomor Kartu Keluarga')
                            ->columnSpanFull(),
                        TextEntry::make('provinsi'),
                        TextEntry::make('kabupaten'),
                        TextEntry::make('kecamatan'),
                        TextEntry::make('kelurahan'),
                        TextEntry::make('kode_pos'),
                        TextEntry::make('dusun.nama'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'aktif' => 'success',
                                'tidak aktif' => 'danger',
                            }),
                        TextEntry::make('alamat')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getRelations(): array
    {
        return [
            AnggotasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeluargas::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'view' => Pages\ViewKeluarga::route('/{record}'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }
}
