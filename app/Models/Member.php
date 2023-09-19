<?php

namespace App\Models;

use App\Casts\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public $fields =[
        ['key' => 'name','display' => 'Name'],
        ['key' => 'status', 'display' => 'Status'],
        ['key' => 'email', 'display' => 'Email'],
        ['key' => 'second_email','display' => 'Secondary Email'],
        ['key' => 'cell_phone', 'display' => 'Cell Phone'],
        ['key' => 'county', 'display' => 'County'],
        ['key' => 'territory','display' => 'Territory'],
        ['key' => 'chapter', 'display' => 'Chapter'],
        ['key' => 'member_number', 'display' => 'Member Number'],
        ['key' => 'availability', 'display' => 'Deployment Availability'],
        ['key' => 'available_now', 'display' => 'Available Now'],
    ];

    protected $with = ['subscriptions','subscriptions.distributionList'];
    protected $casts = [
        'name'              => 'encrypted',
        'email'             => 'encrypted',
        'email_key'         => Hash::class,
        'second_email'      => 'encrypted',
        'second_email_key'  => Hash::class,
        'cell_phone'        => 'encrypted'
    ];

    public function getListIdsAttribute() {
        $ids = [];

        foreach($this->subscriptions as $subscription) {
            $ids[] = $subscription->distribution_list_id;

        }

        return $ids;
    }

    protected $appends = ['permissions','is_admin','listIds'];

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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, "account_id", "account_id");
    }
}
