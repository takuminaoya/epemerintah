<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiPindahPenduduk extends Model
{
    protected $guarded = ["id"];
    protected $guard_name = "web";

    public function pindah(): BelongsTo
    {
        return $this->belongsTo(MutasiPindah::class, 'mutasi_pindah_id');
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function keluarga_sebelumnya(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_sebelumnya');
    }
}
