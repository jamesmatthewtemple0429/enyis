<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthRule extends Model
{
    use HasFactory;

    protected $appends = ['role_name'];

    public function role() {
        return $this->hasOne(Role::class, "id", "role_id");
    }

    public function getRoleNameAttribute() {
        return ($this->role_id == null) ? "N/A" : $this->role->name;
    }
}
