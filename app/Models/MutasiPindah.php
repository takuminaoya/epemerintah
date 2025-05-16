<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MutasiPindah extends Model
{
    protected $guarded = ["id"];
    protected $guard_name = "web";

    public function penduduks(): HasMany
    {
        return $this->hasMany(MutasiPindahPenduduk::class, 'mutasi_pindah_id');
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(Dusun::class);
    }
}
