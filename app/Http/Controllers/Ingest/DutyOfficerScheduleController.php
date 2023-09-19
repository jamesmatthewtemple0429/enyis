<?php

namespace App\Http\Controllers\Ingest;

use App\Http\Controllers\Controller;
use App\Models\Ingest;
use App\Models\Member;
use App\Models\ScheduleRole;
use App\Models\Shift;
use Illuminate\Http\Request;

class DutyOfficerScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('ingest.rcr.schedule.do');
    }

    public function store(Request $request) {
        $members = Member::all();

        $ingest = Ingest::create(['name' => 'doSchedule']);

        $scheduleRoles = [];
        foreach(explode(", ", $request->editors) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 1,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id

                    ];
                }
            }
        }

        foreach(explode(", ", $request->primary) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 2,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id

                    ];
                }
            }
        }

        foreach(explode(", ", $request->backup) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 3,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id

                    ];
                }
            }
        }

        foreach(explode(", ", $request->supervisor) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 4,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        ScheduleRole::insert($scheduleRoles);
    }

    public function edit()
    {
        return view('ingest.rcr.schedule.do_shifts');
    }

    public function update(Request $request) {
        $ingest = Ingest::create(['name' => 'doShifts']);

        $members = Member::all();

        $shifts = [
            [
                'type'  => 1,
                'starts_at' => now()->setTime(0,0,0),
                'ends_at' => now()->setTime(6,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary1')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->setTime(6,0,0),
                'ends_at' => now()->setTime(12,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary2')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->setTime(12,0,0),
                'ends_at' => now()->setTime(18,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary3')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->setTime(18,0,0),
                'ends_at' => now()->addDays(1)->setTime(0,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary4')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(1)->setTime(0,0,0),
                'ends_at' => now()->addDays(1)->setTime(6,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary5')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(1)->setTime(6,0,0),
                'ends_at' => now()->addDays(1)->setTime(12,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary6')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(1)->setTime(12,0,0),
                'ends_at' => now()->addDays(1)->setTime(18,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary7')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(1)->setTime(18,0,0),
                'ends_at' => now()->addDays(2)->setTime(0,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary8')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(2)->setTime(0,0,0),
                'ends_at' => now()->addDays(2)->setTime(6,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary9')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(2)->setTime(6,0,0),
                'ends_at' => now()->addDays(2)->setTime(12,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary10')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(2)->setTime(12,0,0),
                'ends_at' => now()->addDays(2)->setTime(18,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary11')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 1,
                'starts_at' => now()->addDays(2)->setTime(18,0,0),
                'ends_at' => now()->addDays(3)->setTime(0,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('primary12')))
                    ->first()) ? $foundMember->account_id : null
            ],

            [
                'type'  => 2,
                'starts_at' => now()->setTime(0,0,0),
                'ends_at' => now()->setTime(6,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup1')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->setTime(6,0,0),
                'ends_at' => now()->setTime(12,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup2')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->setTime(12,0,0),
                'ends_at' => now()->setTime(18,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup3')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->setTime(18,0,0),
                'ends_at' => now()->addDays(1)->setTime(0,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup4')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(1)->setTime(0,0,0),
                'ends_at' => now()->addDays(1)->setTime(6,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup5')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(1)->setTime(6,0,0),
                'ends_at' => now()->addDays(1)->setTime(12,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup6')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(1)->setTime(12,0,0),
                'ends_at' => now()->addDays(1)->setTime(18,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup7')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(1)->setTime(18,0,0),
                'ends_at' => now()->addDays(2)->setTime(0,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup8')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(2)->setTime(0,0,0),
                'ends_at' => now()->addDays(2)->setTime(6,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup9')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(2)->setTime(6,0,0),
                'ends_at' => now()->addDays(2)->setTime(12,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup10')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(2)->setTime(12,0,0),
                'ends_at' => now()->addDays(2)->setTime(18,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup11')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 2,
                'starts_at' => now()->addDays(2)->setTime(18,0,0),
                'ends_at' => now()->addDays(3)->setTime(0,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('backup12')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 3,
                'starts_at' => now()->setTime(8,0,0),
                'ends_at' => now()->addDays(1)->setTime(8,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('supervisor1')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 3,
                'starts_at' => now()->addDays(1)->setTime(8,0,0),
                'ends_at' => now()->addDays(2)->setTime(8,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('supervisor2')))
                    ->first()) ? $foundMember->account_id : null
            ],
            [
                'type'  => 3,
                'starts_at' => now()->addDays(2)->setTime(8,0,0),
                'ends_at' => now()->addDays(3)->setTime(8,0,0),
                'ingest_id' => $ingest->id,
                'account_id' => ($foundMember = $members
                    ->where('name', $this->formatAccountName($request->get('supervisor3')))
                    ->first()) ? $foundMember->account_id : null
            ],
        ];

        Ingest::where('name', 'doShifts')->where('id','!=', $ingest->id)->delete();

        Shift::insert($shifts);
    }

    private function formatAccountName($editor) {
        $nameParts = explode(" ", $editor);
        $lastNameIndex = (count($nameParts)-1);
        $lastName = $nameParts[$lastNameIndex];

        unset($nameParts[$lastNameIndex]);

        $firstName = implode(" ", $nameParts);

        return $lastName . ", " . $firstName;
    }
}
