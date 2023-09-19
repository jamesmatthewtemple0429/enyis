<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $appends = ['fields'];
    public function roles() {
        return $this->hasMany(SectionRole::class, "section_id", "id")->orderBy('priority');
    }

    public function filters() {
        return $this->hasMany(SectionFilter::class, "section_id", "id")->orderBy('priority');
    }

    public function getFieldsAttribute() {
        return (! isset($this->attributes['fields'])) ? null : json_decode($this->attributes['fields'], true);
    }
}
