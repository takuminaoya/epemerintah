<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use Closure;
use Filament\Actions;
use App\Models\Penduduk;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Resources\KeluargaResource;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class EditKeluarga extends EditRecord
{
    use HasWizard;

    protected static string $resource = KeluargaResource::class;

    public function getRelationManagers(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Detail Keluarga')
                ->schema([
                    Section::make('Penomoran')
                        ->collapsible()
                        ->columns([
                            'sm' => 2,
                            'xl' => 2,
                        ])
                        ->description('Detail segala penomoran surat dari no kk, uuid, dll')
                        ->schema([
                            TextInput::make('uuid')
                                ->label('UUID')
                                ->required()
                                ->default(function () {
                                    return Str::uuid()->toString();
                                })
                                ->readOnly()
                                ->maxLength(36),
                            TextInput::make('nomor')
                                ->label("Nomor Kartu Keluarga")
                                ->required()
                                ->maxLength(16),
                        ]),
                    Section::make('Informasi Wilayah Domisili')
                        ->columns([
                            'sm' => 2,
                            'xl' => 2,
                        ])
                        ->collapsible()
                        ->description('Detail domisili keluarga seperti provinsi, desa, alamat dll.')
                        ->schema([
                            TextInput::make('provinsi')
                                ->required()
                                ->maxLength(255)
                                ->readOnly()
                                ->default('bali'),
                            TextInput::make('kabupaten')
                                ->required()
                                ->readOnly()
                                ->maxLength(255)
                                ->default('badung'),
                            TextInput::make('kecamatan')
                                ->required()
                                ->readOnly()
                                ->maxLength(255)
                                ->default('kuta selatan'),
                            TextInput::make('kelurahan')
                                ->required()
                                ->readOnly()
                                ->maxLength(255)
                                ->default('desa ungasan'),
                            TextInput::make('kode_pos')
                                ->required()
                                ->numeric()
                                ->readOnly()
                                ->maxLength(5)
                                ->default(80364),
                            Select::make('dusun_id')
                                ->label('Dusun/Banjar')
                                ->relationship('dusun', 'nama')
                                ->required()
                                ->preload()
                                ->searchable(),
                            TextInput::make('alamat')
                                ->required()
                                ->maxLength(255),
                        ])
                ]),
            Step::make('Daftar Anggota Keluarga')
                ->schema([
                    Repeater::make('anggotas')
                        ->relationship()
                        ->collapsible()
                        ->collapsed()
                        ->persistCollapsed()
                        ->cloneable()
                        ->minItems(1)
                        ->deleteAction(
                            fn(Action $action) => $action->requiresConfirmation(),
                        )
                        ->schema([
                            Section::make('Penomoran')
                                ->collapsible()
                                ->columns([
                                    'sm' => 2,
                                    'xl' => 2,
                                ])
                                ->description('Detail segala penomoran surat dari no kk, uuid, dll')
                                ->schema([
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
                                        ->unique(ignoreRecord: true)
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
                                        ->searchable()
                                        ->preload()
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
                        ])
                        ->itemLabel(fn(array $state): ?string => $state['nama'] ?? null),
                ]),
            Step::make('Upload File Pendukung')
                ->schema([
                    FileUpload::make('foto_kk')
                        ->image()
                        ->imageEditor()
                ])
        ];
    }
}
