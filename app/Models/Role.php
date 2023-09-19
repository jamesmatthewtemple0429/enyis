<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $with = ['permissions'];

    public $fields = [
        ['key' => 'name','display' => 'Name'],
        ['key' => 'description','display' => 'Description'],
    ];
    protected $appends = ['permission_ids'];

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function getPermissionIdsAttribute() {
        return $this->permissions->pluck('id');
    }
}
