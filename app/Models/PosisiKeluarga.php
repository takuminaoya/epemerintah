<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class PosisiKeluarga extends Model
{
    use HasRoles, HasPanelShield;

    protected $guarded = ["id"];
}
