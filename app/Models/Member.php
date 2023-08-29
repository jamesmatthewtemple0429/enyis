<?php

namespace App\Models;

use App\Casts\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $casts = [
        'name'              => 'encrypted',
        'email'             => 'encrypted',
        'email_key'         => Hash::class,
        'second_email'      => 'encrypted',
        'second_email_key'  => Hash::class,
        'cell_phone'        => 'encrypted'
    ];

    protected $appends = ['permissions','is_admin'];

    public function roleAssignments() {
        return $this->hasMany(MemberRole::class, "account_id","account_id");
    }

    public function getPermissionsAttribute() {
        $permissions = [];

        foreach($this->roleAssignments as $assignment) {
            $permissions = array_merge($permissions, $assignment->role->permissions->toArray());
        }

        return $permissions;
    }

    public function getIsAdminAttribute() {
        $isAdmin = false;

        foreach($this->roleAssignments as $assignment) {
            if($assignment->role->is_admin) {
                $isAdmin = true;
            }
        }

        return $isAdmin;
    }
}
