<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionList extends Model
{
    use HasFactory;

    public $appends = ['trigger'];

    public function publications() {
        return $this->hasMany(Publication::class, "distribution_list_id","id");
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class, "distribution_list_id","id");
    }
    public function report() {
        return $this->hasOne(Report::class, "id", "report_id");
    }
    public function getTriggerAttribute() {
        //if(! isset($attributes['type'])) return;
        if($this->attributes['type'] == 1) {
            $triggerText = $this->frequencyText();

            if($this->attributes['frequency'] == 2) {
                $triggerText .= " " . $this->dayText();
            } else if($this->attributes['frequency'] == 3) {
                $triggerText .= " on the " . ordinal($this->date);
            }

            $triggerText .= " at " . $this->timeText();
        } else {

        }

        return $triggerText;
    }

    private function timeText() {
        switch($this->attributes['time']) {
            case 0:
                return '12 AM';
            case 1:
                return '1 AM';
            case 2:
                return '2 AM';
            case 3:
                return '3 AM';
            case 4:
                return '4 AM';
            case 5:
                return '5 AM';
            case 6:
                return '6 AM';
            case 7:
                return '7 AM';
            case 8:
                return '8 AM';
            case 9:
                return '9 AM';
            case 10:
                return '10 AM';
            case 11:
                return '11 AM';
            case 12:
                return '12 PM';
            case 13:
                return '1 PM';
            case 14:
                return '2 PM';
            case 15:
                return '3 PM';
            case 16:
                return '4 PM';
            case 17:
                return '5 PM';
            case 18:
                return '6 PM';
            case 19:
                return '7 PM';
            case 20:
                return '8 PM';
            case 21:
                return '9 PM';
            case 22:
                return '10 PM';
            case 23:
                return '11 PM';
        }
    }
    private function frequencyText() {
        switch($this->attributes['frequency']) {
            case 1:
                return 'Daily';
            case 2:
                return 'Weekly';
            case 3:
                return 'Monthly';
        }
    }

    private function dayText() {
        switch($this->attributes['day']) {
            case 1:
                return 'Monday';
            case 2:
                return 'Tuesday';
            case 3:
                return 'Wednesday';
            case 4:
                return 'Thursday';
            case 5:
                return 'Friday';
            case 6:
                return 'Saturday';
            case 7:
                return 'Sunday';
        }
    }
}
