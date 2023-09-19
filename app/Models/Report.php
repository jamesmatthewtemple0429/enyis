<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $fields = [
        ['key' => 'name','display' => 'Name'],
        ['key' => 'description','display' => 'Description'],
    ];

    public function sections() {
        return $this->hasMany(Section::class, "report_id", "id");
    }
}
