<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Dusun;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Imports\PendudukImporter;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Actions\BulkActionGroup;
use App\Filament\Resources\PendudukResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PendudukResource\RelationManagers;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Kependudukan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Penomoran')
                    ->collapsible()
                    ->columns([
                        'sm' => 2,
                        'xl' => 2,
                    ])
                    ->description('Detail segala penomoran surat dari no kk, uuid, dll')
                    ->schema([
                        TextInput::make('kk')
                            ->label("Nomor Kartu Keluarga")
                            ->required()
                            ->reactive()
                            ->dehydrated(false)
                            ->afterStateUpdated(fn($set, $state) => $set('keluarga_id', Keluarga::where('nomor', $state)->value('id')))
                            ->maxLength(16),
                        TextInput::make('keluarga_id')
                            ->readOnly()
                            ->required(),
                        TextInput::make('uuid')
                            ->label('UUID')
                            ->required()
                            ->default(function () {
                                return Str::uuid()->toString();
                            })
                            ->readOnly()
                            ->maxLength(36),
                        TextInput::make('nik')
                            ->label("Nomor Induk Kependudukan")
                            ->required()
                            ->unique('penduduks', 'nik')
                            ->live()
                            ->maxLength(16),
                    ]),
                Section::make('Informasi Pribadi')
                    ->columns([
                        'sm' => 3,
                        'xl' => 3,
                    ])
                    ->collapsible()
                    ->description('Detail pribadi dar penduduk seperti nama alamat tgl lahir dll.')
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('tanggal_lahir')
                            ->required(),
                        TextInput::make('tempat_lahir')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('alamat')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                        Select::make('kelamin_id')
                            ->label('Jenis Kelamin')
                            ->relationship('kelamin', 'nama')
                            ->required(),
                        Select::make('agama_id')
                            ->label('Agama')
                            ->relationship('agama', 'nama')
                            ->required(),

                        Select::make('golongan_darah_id')
                            ->label('Golongan Darah')
                            ->relationship('golongan_darah', 'nama')
                            ->required(),
                        Select::make('status_pernikahan_id')
                            ->label('Status Pernikahan')
                            ->relationship('status_pernikahan', 'nama')
                            ->required(),
                        Select::make('Pendidikan')
                            ->label('Pendidikan')
                            ->relationship('pendidikan', 'nama')
                            ->required(),
                        Select::make('pekerjaan_id')
                            ->label('Pekerjaan')
                            ->relationship('pekerjaan', 'nama')
                            ->required(),
                        Select::make('posisi_keluarga_id')
                            ->label('Posisi Dalam Keluarga')
                            ->relationship('posisi_keluarga', 'nama')
                            ->required()
                    ]),
                Section::make('Informasi Kewarganegaraan')
                    ->columns([
                        'sm' => 2,
                        'xl' => 2,
                    ])
                    ->collapsible()
                    ->description('Detail pribadi dari orang tua penduduk seperti nama alamat tgl lahir dll.')
                    ->schema([
                        Select::make('kewarganegaraan')
                            ->required()
                            ->options([
                                'WNI' => 'Warga Negara Indonesia',
                                'WNA' => 'Warga Negara Asing'
                            ])
                            ->reactive()
                            ->default('WNI'),
                        TextInput::make('negara')
                            ->disabled(
                                fn($get) => $get('kewarganegaraan') === 'WNI'
                            )
                            ->reactive()
                            ->required()
                            ->default('Indonesia'),
                        TextInput::make('no_kitap')
                            ->visible(
                                fn($get) => $get('kewarganegaraan') === 'WNA'
                            )
                            ->reactive()
                            ->required()
                            ->maxLength(16),
                        TextInput::make('no_paspor')
                            ->visible(
                                fn($get) => $get('kewarganegaraan') === 'WNA'
                            )
                            ->reactive()
                            ->required()
                            ->maxLength(255),
                    ]),
                Section::make('Informasi Orang Tua')
                    ->columns([
                        'sm' => 2,
                        'xl' => 2,
                    ])
                    ->collapsible()
                    ->description('Detail pribadi dari orang tua penduduk seperti nama alamat tgl lahir dll.')
                    ->schema([
                        TextInput::make('nik_ayah')
                            ->required()
                            ->maxLength(16),
                        TextInput::make('nama_ayah')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nik_ibu')
                            ->required()
                            ->live()
                            ->maxLength(16),
                        TextInput::make('nama_ibu')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keluarga.nomor')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('keluarga.dusun.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('posisi_keluarga.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'tidak aktif' => 'danger',
                        'pindah' => 'warning',
                        'meninggal' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('alamat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('posisi_keluarga')
                    ->relationship('posisi_keluarga', 'nama'),
                SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Masih Aktif',
                        'tidak aktif' => 'Sudah Tidak Aktif',
                    ])
            ])
            ->headerActions([
                ImportAction::make('import Penduduk')
                    ->importer(PendudukImporter::class)
                    ->maxRows(18000)
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Meninggal')
                    ->icon('heroicon-o-user-minus')
                    ->color('danger')
                    ->visible(function ($record) {
                        return $record->status != 'meninggal' ? true : false;
                    })
                    ->steps([
                        Step::make('Detail Informasi Kematian')
                            ->schema([
                                Placeholder::make('Daftar Penduduk Yang Pindah')
                                    ->columnSpanFull()
                                    ->content(
                                        function ($livewire): string {
                                            $knamas = [];
                                            foreach ($livewire->getSelectedTableRecords() as $rcd) {
                                                $knamas[] = $rcd->nama;
                                            }

                                            return implode(' , ', $knamas);
                                        }
                                    ),
                                DatePicker::make('tanggal_pengajuan')
                                    ->readOnly()
                                    ->default(date('Y-m-d')),
                                DatePicker::make('pindah_pada')
                                    ->required(),
                                TextInput::make('kk_tujuan')
                                    ->exists('keluargas', 'nomor')
                                    ->required(),
                                Select::make('dusun_tujuan')
                                    ->options(Dusun::all()->pluck('nama', 'id'))
                                    ->searchable()
                                    ->preload(),
                                Textarea::make('alamat_pindah')
                                    ->columnSpanFull()
                                    ->required(),
                                Textarea::make('alasan_pindah')
                                    ->columnSpanFull()
                                    ->required()
                            ])
                            ->columns(2),
                        Step::make('File-File Pendukung')
                            ->schema([
                                FileUpload::make('foto_kk')
                                    ->imageEditor(),
                                FileUpload::make('foto_ktp')
                                    ->imageEditor(),
                                FileUpload::make('surat_keterangan_dokter')
                                    ->imageEditor()
                            ]),
                    ])
                    ->action(
                        function ($records, array $data): void {
                            dd($data['alasan']);
                        }
                    )
                    ->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                ]),

                BulkActionGroup::make([
                    BulkAction::make('Pindah Domisili')
                        ->icon('heroicon-o-arrow-path')
                        ->steps([
                            Step::make('Detail Informasi Perpindahan Penduduk')
                                ->schema([
                                    Placeholder::make('Daftar Penduduk Yang Pindah')
                                        ->columnSpanFull()
                                        ->content(
                                            function ($livewire): string {
                                                $knamas = [];
                                                foreach ($livewire->getSelectedTableRecords() as $rcd) {
                                                    $knamas[] = $rcd->nama;
                                                }

                                                return implode(' , ', $knamas);
                                            }
                                        ),
                                    DatePicker::make('tanggal_pengajuan')
                                        ->readOnly()
                                        ->default(date('Y-m-d')),
                                    DatePicker::make('pindah_pada')
                                        ->required(),
                                    TextInput::make('kk_tujuan')
                                        ->exists('keluargas', 'nomor')
                                        ->required(),
                                    Select::make('dusun_tujuan')
                                        ->options(Dusun::all()->pluck('nama', 'id'))
                                        ->searchable()
                                        ->preload(),
                                    Textarea::make('alamat_pindah')
                                        ->columnSpanFull()
                                        ->required(),
                                    Textarea::make('alasan_pindah')
                                        ->columnSpanFull()
                                        ->required()
                                ])
                                ->columns(2),
                            Step::make('File-File Pendukung')
                                ->schema([
                                    FileUpload::make('foto_kk')
                                        ->imageEditor()
                                ]),
                        ])
                        ->action(
                            function ($records, array $data): void {
                                dd($data['alasan']);
                            }
                        )->slideOver(),
                    BulkAction::make('Pindah Keluar Desa'),
                ])
                    ->label('Mutasi')
                    ->icon('heroicon-o-document')
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenduduks::route('/'),
            'create' => Pages\CreatePenduduk::route('/create'),
            'view' => Pages\ViewPenduduk::route('/{record}'),
            'edit' => Pages\EditPenduduk::route('/{record}/edit'),
        ];
    }
}
