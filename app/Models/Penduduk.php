<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model
{
    use SoftDeletes;

    protected $guarded = ["id"];
    protected $guard_name = "web";

    public function golongan_darah(): BelongsTo
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function status_pernikahan(): BelongsTo
    {
        return $this->belongsTo(StatusPernikahan::class);
    }
    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class);
    }
    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class);
    }

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
}
