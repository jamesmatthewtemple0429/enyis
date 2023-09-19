<?php

namespace App\Http\Controllers\Ingest;

use App\Http\Controllers\Controller;
use App\Models\County;
use App\Models\Ingest;
use App\Models\Member;
use App\Models\ScheduleRole;
use App\Models\Shift;
use Illuminate\Http\Request;

class DatScheduleController extends Controller
{
    public function index() {
        County::where('id','!=',null)->update(['schedule_imported' => false]);
    }

    public function get() {
        return view('ingest.rcr.schedule.init',['county' => County::where('schedule_imported',false)->first()]);
    }
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('ingest.rcr.schedule.dat');
    }

    public function store(Request $request) {
        $members = Member::all();

        $ingest = Ingest::create(['name' => strtolower($request->county) . "Schedule"]);

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

        foreach(explode(", ", $request->svO) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 5,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id

                    ];
                }
            }
        }

        foreach(explode(", ", $request->svA) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 6,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id

                    ];
                }
            }
        }

        foreach(explode(", ", $request->saO) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 7,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        foreach(explode(", ", $request->saA) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 8,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        foreach(explode(", ", $request->spO) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 9,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        foreach(explode(", ", $request->spA) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 10,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        foreach(explode(", ", $request->observers) as $editor) {
            $nameParts = explode(" ", $editor);
            $lastNameIndex = (count($nameParts)-1);
            $lastName = $nameParts[$lastNameIndex];

            unset($nameParts[$lastNameIndex]);

            $firstName = implode(" ", $nameParts);

            $accountName = $lastName . ", " . $firstName;

            foreach($members as $member) {
                if($member->name == $accountName) {
                    $scheduleRoles[] = [
                        'type' => 11,
                        'schedule' => $request->name,
                        'account_id' => $member->account_id,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        $realRoles = [];

        foreach($scheduleRoles as $role) {
            $realRoles[] = array_merge($role, ['county' => $request->county]);
        }

        ScheduleRole::insert($realRoles);

        County::where('name',$request->county)->update(['schedule_imported' => true]);
    }

    public function edit()
    {
        return view('ingest.rcr.schedule.do_shifts');
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
