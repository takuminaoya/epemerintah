<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class Pendidikan extends Model
{
    use HasRoles, HasPanelShield;

    protected $guarded = ["id"];
    protected $guard_name = "web";
}
