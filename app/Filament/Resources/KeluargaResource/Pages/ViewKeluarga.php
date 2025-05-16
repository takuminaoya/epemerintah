<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Models\Agama;
use App\Models\Dusun;
use Filament\Actions;
use App\Models\Kelamin;
use App\Models\Penduduk;
use App\Models\Pekerjaan;
use App\Models\MutasiLahir;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use App\Models\GolonganDarah;
use Ramsey\Uuid\Type\Integer;
use App\Models\PosisiKeluarga;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Resources\KeluargaResource;
use Filament\Forms\Components\Actions\Action as ActionForm;

class ViewKeluarga extends ViewRecord
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kelahiran')
                ->icon('tabler-plus')
                ->color(Color::Blue)
                ->slideOver()
                ->modalWidth(MaxWidth::FiveExtraLarge)
                ->modalIcon('tabler-diaper')
                ->modalHeading('Formulir Mutasi Kelahiran')
                ->modalDescription('Dokumen atau formulir resmi yang digunakan untuk mencatat dan melaporkan peristiwa kelahiran seseorang, biasanya bayi baru lahir')
                ->steps([
                    Step::make('Detail Informasi Kelahiran')
                        ->schema([
                            Hidden::make('keluarga_id')
                                ->label('Keluarga ID')
                                ->default(
                                    function($record) {
                                        return $record->id;
                                    }
                                ),
                            TextInput::make('kk')
                                ->label('Nomor Kartu Keluarga')
                                ->dehydrated(false)
                                ->default(
                                    function($record) {
                                        return $record->nomor;
                                    }
                                )
                                ->disabled(),
                            TextInput::make('nik')
                                ->label('Nomor Induk')
                                ->nullable(),
                            TextInput::make('nama')
                                ->required(),
                            DatePicker::make('tanggal_lahir')
                                ->required(),
                            TextInput::make('tempat_lahir')
                                ->required()
                                ->maxLength(255),

                            Select::make('kelamin_id')
                                ->label('Jenis Kelamin')
                                ->options(Kelamin::all()->pluck('nama', 'id'))
                                ->required(),
                            Select::make('agama_id')
                                ->label('Agama')
                                ->options(Agama::all()->pluck('nama', 'id'))
                                ->required(),
                            Select::make('golongan_darah_id')
                                ->label('Golongan Darah')
                                ->options(GolonganDarah::all()->pluck('nama', 'id'))
                                ->required(),
                            Select::make('posisi_keluarga_id')
                                ->label('Posisi Dalam Keluarga')
                                ->options(PosisiKeluarga::all()->pluck('nama', 'id'))
                                ->required(),
                            Select::make('lahir_dari')
                                ->options([
                                    "pasangan_suami_istri" => "pasangan suami istri",
                                    "anak_seorang_ibu" => "anak seorang ibu",
                                ])
                                ->required()
                                
                        ])
                        ->columns(2),

                    Step::make('Detail Orang Tua')
                        ->schema([
                            Repeater::make('anggotas')
                                ->collapsible()
                                ->cloneable()
                                ->minItems(
                                    function ($get) {
                                        return $get('lahir_dari') == 'pasangan_suami_istri' ? 2 : 1;
                                    }
                                )
                                ->maxItems(
                                    function ($get) {
                                        return $get('lahir_dari') == 'pasangan_suami_istri' ? 2 : 1;
                                    }
                                )
                                ->schema([
                                    Hidden::make('keluarga_id')
                                        ->default(
                                            function($record) {
                                                return $record->id;
                                            }
                                        ),
                                    TextInput::make('nik')
                                        ->label('Nomor Induk')
                                        ->maxLength(16)
                                        ->nullable(),
                                    TextInput::make('nama')
                                        ->required(),
                                    DatePicker::make('tanggal_lahir')
                                        ->required(),
                                    TextInput::make('tempat_lahir')
                                        ->required()
                                        ->maxLength(255),
                                    Select::make('pekerjaan_id')
                                        ->label('Pekerjaan')
                                        ->options(Pekerjaan::all()->pluck('nama', 'id'))
                                        ->required(),
                                    Select::make('tipe_pasangan')
                                        ->label('Ibu/Ayah?')
                                        ->options([
                                            'ayah' => 'ayah',
                                            'ibu' => 'ibu'
                                        ])
                                        ->required(),
                                    Hidden::make('tipe_anggota')
                                        ->default('orang_tua'),
                                    Select::make('dusun_id')
                                        ->label('Dusun')
                                        ->options(Dusun::all()->pluck('nama', 'id'))
                                        ->required(),
                                    Textarea::make('alamat')
                                        ->columnSpanFull()
                                        ->required()
                                        ->maxLength(255),
                                    FileUpload::make('foto_ktp')
                                        ->columnSpanFull()
                                        ->nullable()
                                        ->image()
                                        ->optimize('webp')
                                        ->imageEditor(),
                                ])
                                ->columns(2)
                                ->itemLabel(fn(array $state): ?string => $state['nama'] ?? null),
                        ]),
                    Step::make('Detail Saksi')
                        ->schema([
                            Repeater::make('saksis')
                                ->collapsible()
                                ->cloneable()
                                ->minItems(2)
                                ->maxItems(2)
                                ->schema([
                                    Hidden::make('keluarga_id')
                                        ->default(
                                            function($record) {
                                                return $record->id;
                                            }
                                        ),
                                    TextInput::make('nik')
                                        ->label('Nomor Induk')
                                        ->exists('penduduks', 'nik')
                                        ->maxLength(16)
                                        ->reactive()
                                        ->afterStateUpdated(
                                            function($state, $set) {
                                                $p = Penduduk::where('nik', $state)->first();
                                                if($p){
                                                    $set('nama', $p->nama);
                                                    $set('tanggal_lahir', $p->tanggal_lahir);
                                                    $set('tempat_lahir', $p->tempat_lahir);
                                                    $set('pekerjaan_id', $p->pekerjaan_id);
                                                    $set('dusun_id', $p->keluarga->dusun_id);
                                                    $set('alamat', $p->alamat);
                                                }
                                            }
                                        )
                                        ->nullable(),
                                    TextInput::make('nama')
                                        ->required(),
                                    DatePicker::make('tanggal_lahir')
                                        ->required(),
                                    TextInput::make('tempat_lahir')
                                        ->required()
                                        ->maxLength(255),
                                    Select::make('pekerjaan_id')
                                        ->label('Pekerjaan')
                                        ->options(Pekerjaan::all()->pluck('nama', 'id'))
                                        ->required(),
                                    Hidden::make('tipe_pasangan')
                                        ->default('saksi'),
                                    Hidden::make('tipe_anggota')
                                        ->default('saksi'),
                                    Select::make('dusun_id')
                                        ->label('Dusun')
                                        ->options(Dusun::all()->pluck('nama', 'id'))
                                        ->required(),
                                    Textarea::make('alamat')
                                        ->columnSpanFull()
                                        ->required()
                                        ->maxLength(255),
                                    FileUpload::make('foto_ktp')
                                        ->columnSpanFull()
                                        ->image()
                                        ->nullable()
                                        ->optimize('webp')
                                        ->imageEditor(),
                                ])
                                ->columns(2)
                                ->itemLabel(fn(array $state): ?string => $state['nama'] ?? null),
                        ]),
                    Step::make('File-File Pendukung')
                        ->schema([
                            FileUpload::make('surat_pernyataan_saksi')
                                ->image()
                                ->nullable()
                                ->optimize('webp')
                                ->imageEditor(),
                            FileUpload::make('foto_kk')
                                ->image()
                                ->nullable()
                                ->optimize('webp')
                                ->imageEditor(),
                            FileUpload::make('foto_surat_keterangan_kelahiran_dokter')
                                ->image()
                                ->nullable()
                                ->optimize('webp')
                                ->imageEditor(),
                            FileUpload::make('foto_surat_dokter')
                                ->image()
                                ->nullable()
                                ->optimize('webp')
                                ->imageEditor()
                        ]),
                ])
                ->action(
                    function ($data) {
                        // save mutasi
                        $ml = MutasiLahir::create([
                            "keluarga_id" => $data['keluarga_id'],
                            "nik" => $data['nik'],
                            "nama" => $data['nama'],
                            "tanggal_lahir" => $data['tanggal_lahir'],
                            "tempat_lahir" => $data['tempat_lahir'],
                            "kelamin_id" => $data['kelamin_id'],
                            "agama_id" => $data['agama_id'],
                            "golongan_darah_id" => $data['golongan_darah_id'],
                            "posisi_keluarga_id" => $data['posisi_keluarga_id'],
                            "lahir_dari" => $data['lahir_dari'],
                            "surat_pernyataan_saksi" => $data['surat_pernyataan_saksi'],
                            "foto_kk" => $data['foto_kk'],
                            "foto_surat_keterangan_kelahiran_dokter" => $data['foto_surat_keterangan_kelahiran_dokter'],
                            "foto_surat_dokter" => $data['foto_surat_dokter']
                        ]);

                        // save anggota
                        $ml->anggotas()->createMany($data['anggotas']);

                        // save saksi
                        $ml->anggotas()->createMany($data['saksis']);

                        // create penduduk
                        $nik = ($data['nik'] != "") ? $data['nik'] : substr("0000000000{$ml->id}", 15);
                        $pinputs = [
                            "uuid" => Str::uuid(),
                            "keluarga_id" => $data['keluarga_id'],
                            "kk" => $ml->keluarga->nomor,
                            "nik" => $nik,
                            "nama" => $data['nama'],
                            "alamat" => $ml->keluarga->alamat,
                            "tanggal_lahir" => $data['tanggal_lahir'],
                            "tempat_lahir" => $data['tempat_lahir'],
                            "kelamin_id" => $data['kelamin_id'],
                            "agama_id" => $data['agama_id'],
                            "golongan_darah_id" => $data['golongan_darah_id'],
                            "posisi_keluarga_id" => $data['posisi_keluarga_id'],
                            "status" => "lahir"
                        ];

                        foreach($data['anggotas'] as $agg){
                            $pinputs['nik_' . $agg['tipe_pasangan']] = $agg['nik'];
                            $pinputs['nama_' . $agg['tipe_pasangan']] = $agg['nama'];
                        }

                        Penduduk::create($pinputs);

                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                    }
                )
        ];
    }
}
