<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class GolonganDarah extends Model
{
    use HasRoles, HasPanelShield;

    protected $guarded = ["id"];
}
