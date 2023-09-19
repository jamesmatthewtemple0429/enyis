<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\PositionAssignment;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PositionAssignmentImport implements ToModel, WithHeadingRow
{
    public function __construct(protected $ingest, protected $members) {

    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $foundMember = $this->members->filter(function($member) use ($row) {
           return $member->name === $row['supervisor'];
        })->first();

        if($row['account_id'] == 990331 && str_contains($row['position'], "Disaster Program Manager - Territory 4 (Employee)")) {
            return;
        }

        if($row['account_id'] == 110419 && str_contains($row['position'], "Disaster Program Manager - Territory 5 (Employee)")) {
            return;
        }

            return new PositionAssignment([
                'account_id'        => $row['account_id'],
                'supervisor'        => optional($foundMember)->account_id,
                'name'              => trim(Str::after($row['position'],"DCS: ")),
                'type'              => $row['position_type'],
                'sub_type'          => $row['sub_type'],
                'ingest_id'         => $this->ingest->id
            ]);
    }

    public function headingRow() {
        return 5;
    }
}
