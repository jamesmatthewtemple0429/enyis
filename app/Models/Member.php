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
}
