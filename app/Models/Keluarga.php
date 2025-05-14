<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Keluarga extends Model
{
    use HasRoles, HasPanelShield, SoftDeletes;

    protected $guarded = ["id"];
    protected $guard_name = "web";

    public function anggotas(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'keluarga_id');
    }

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(Dusun::class);
    }
}
