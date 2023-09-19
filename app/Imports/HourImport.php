<?php

namespace App\Imports;

use App\Models\PositionAssignment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Ingest;
use Illuminate\Support\Str;
use App\Models\HourListing;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class HourImport implements ToModel, WithHeadingRow
{
    public function __construct(protected $ingest) {

    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
             return new HourListing([
                 'account_id'            => $row['account_id'],
                 'activity'              => $row['activity'],
                 'type'                  => $row['hours_type'],
                 'status'                => $row['status'],
                 'hours'                 => $row['hours'],
                 'position'              => trim(Str::after($row['position'], "DCS:")),
                 'date'                  => Date::excelToDateTimeObject($row['date']),
                 'ingest_id'             => $this->ingest->id
            ]);
    }

    public function headingRow() {
        return 5;
    }
}
