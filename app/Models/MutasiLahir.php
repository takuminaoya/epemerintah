<?php

namespace App\Models;

use App\Models\Agama;
use App\Models\Kelamin;
use App\Models\Keluarga;
use App\Models\GolonganDarah;
use App\Models\PosisiKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MutasiLahir extends Model
{
    protected $guarded = ["id"];
    protected $guard_name = "web";

    public function posisi_keluarga(): BelongsTo
    {
        return $this->belongsTo(PosisiKeluarga::class);
    }

    public function kelamin(): BelongsTo
    {
        return $this->belongsTo(Kelamin::class);
    }

    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class);
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function golongan_darah(): BelongsTo
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function anggotas() : HasMany {
        return $this->hasMany(MutasiLahirAnggota::class, 'mutasi_lahir_id')->where('tipe_anggota', 'orang_tua');
    }

    public function saksis() : HasMany {
        return $this->hasMany(MutasiLahirAnggota::class, 'mutasi_lahir_id')->where('tipe_anggota', 'saksi');
    }
}
