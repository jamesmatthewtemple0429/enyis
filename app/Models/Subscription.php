<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = "distribution_list_member";

    public function distributionList() {
        return $this->hasOne(DistributionList::class, "id", "distribution_list_id");
    }

    public function member() {
        return $this->hasOne(Member::class, "account_id", "account_id");
    }
}
