<?php

    use App\Models\PositionAssignment;
    use App\Models\InterimAssignment;
    use App\Models\Shift;
    use Illuminate\Support\Str;
    function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    function currentDos() {
        $primaryDo = optional(Shift::with('member')
            ->where('type',1)
            ->where('starts_at','<=',now())
            ->where('ends_at','>=',now())
            ->first())
            ->member;

        $backupDo = optional(Shift::with('member')
            ->where('type',2)
            ->where('starts_at','<=',now())
            ->where('ends_at','>=',now())
            ->first())
            ->member;

        $supervisor = optional(Shift::with('member')
            ->where('type',3)
            ->where('starts_at','<=',now())
            ->where('ends_at','>=',now())
            ->first())
            ->member;

        return [
            'primary' => $primaryDo,
            'backup' => $backupDo,
            'supervisor' => $supervisor
        ];
    }
    function availableModels() {
        return [
            'Announcement',
            'County',
            'InterimAssignment',
            'Member',
            'PositionAssignment',
            'Role',
            'StateOfEmergency',
            'SystemIssue',
            'TravelEdict'
        ];
    }

    function availableFields() {
        return [
            'Announcement' => [
                'audience',
                'message',
                'expires_at',
                'effective_at'
            ],
            'County' => [
                'name',
                'territory',
                'chapter'
            ],
            'InterimAssignment' => [
                ''
            ]
        ];
    }
    function getRoleInterim($role) {
        $interims = cache()->remember('interims', $seconds = 360, function () {
            return InterimAssignment::all();
        });

        return $interims->filter(function($position) use ($role) {
            return now() < $position->expires_at && trim(preg_replace("/\([^)]+\)/","",$role->position)) === $position->position;
        })->first();
    }


    function getRoleMembers($role) {
        $positions = cache()->remember('positions', $seconds = 360, function () {
            return PositionAssignment::with(['member'])->get();
        });

        $position = $positions->filter(function($position) use ($role) {
            return str_contains($position->name, $role->position);
        });

        $allowedPosition = ($role->allow_multiple) ? $position : [$position->first()];

        return ($position->count() == 0) ? [null] : $allowedPosition;
    }

    function format_phone($phone) {
        return "(" . $phone[2] . $phone[3] . $phone[4] . ") " . $phone[5] . $phone[6] .  $phone[7] . "-" . $phone[8] . $phone[9] . $phone[10] . $phone[11];
    }

    function maybe($assignedPosition, $interim = null) {
       // dd($assignedPosition, is_null($assignedPosition));
        if( is_null($assignedPosition) ) {
            $user = [ "name"    => 'Vacant', 'cell_phone' => 'Vacant','is_interim' => false,'interim_until' => null];

        } else {
           // dd($assignedPosition);
            $user = ['name' => $assignedPosition->member->name, 'cell_phone' => format_phone($assignedPosition->member->cell_phone),'is_interim' => false, 'interim_until' => null];
        }

        return (is_null($interim)) ? $user : ['name' => $interim->member->name, 'cell_phone' => format_phone($interim->member->cell_phone),'is_interim' => true, 'interim_until' => $interim->expires_at->format('M d, Y h:i A')];
    }
