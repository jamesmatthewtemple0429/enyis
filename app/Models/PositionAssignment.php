<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionAssignment extends Model
{
    use HasFactory;

    public $fields = [
        ['key' => 'member_name','display' => 'Name'],
        ['key' => 'supervisor_name', 'display' => 'Supervisor'],
        ['key' => 'position', 'display' => 'Position'],
        ['key' => 'type','display' => 'Type'],
        ['key' => 'sub_type', 'display' => 'Sub Type'],
    ];
    public function member() {
        return $this->hasOne(Member::class,"account_id","account_id");
    }
}
