<?php

namespace App\Console\Commands\Syncs;

use App\Models\AuthRule;
use App\Models\InterimMember;
use App\Models\Member;
use App\Models\MemberRole;
use App\Models\PositionAssignment;
use Illuminate\Console\Command;

class SyncAuthRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:sync-auth-rules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userRoles = [];
        $userInterims = [];

        MemberRole::truncate();
        InterimMember::truncate();

        foreach(AuthRule::all() as $rule) {
            $members = [];

            switch($rule->subject) {
                case 'Member':
                    $value = ($rule->operator === 'like') ? "%{$rule->value}%" : $rule->value;

                    $members = Member::where($rule->field, $rule->operator, $value)
                        ->get();

                    break;
                case 'Position':
                    $value = ($rule->operator === 'like') ? "%{$rule->value}%" : $rule->value;

                    $positions = PositionAssignment::with('member')->where($rule->field, $rule->operator, $value)
                        ->get();

                    foreach($positions as $position) {
                        $members[] = $position->member;
                    }

                    break;
            }

            if(count($members)) {
                foreach ($members as $member) {
                    if ($rule->role_id !== null) {
                        $userRoles[] = [
                            'account_id' => $member->account_id,
                            'role_id' => $rule->role_id
                        ];
                    }

                    if($rule->allow_interim) {
                        $userInterims[] = [
                            'account_id' => $member->account_id,
                            'name'  => $rule->allow_interim
                        ];
                    }
                }


            }
        }

        MemberRole::insert($userRoles);
        InterimMember::insert($userInterims);
    }
}
