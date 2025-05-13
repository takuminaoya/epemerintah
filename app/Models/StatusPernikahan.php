<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class StatusPernikahan extends Model
{
    use HasRoles, HasPanelShield;

    protected $guarded = ["id"];
    protected $guard_name = "web";
}
