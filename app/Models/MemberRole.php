<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRole extends Model
{
    use HasFactory;

    protected $table = "member_role";


    public function role() {
        return $this->hasOne(Role::class,"id","role_id");
    }

    public function member() {
        return $this->hasOne(Member::class,"account_id","account_id");
    }
}
