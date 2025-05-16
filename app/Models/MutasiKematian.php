<?php

namespace App\Models;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiKematian extends Model
{
    protected $guarded = ["id"];
    protected $guard_name = "web";

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }
}
