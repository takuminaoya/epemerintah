<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Kelamin extends Model
{
    use HasRoles, HasPanelShield;

    protected $guarded = ["id"];
    protected $guard_name = "web";
}
