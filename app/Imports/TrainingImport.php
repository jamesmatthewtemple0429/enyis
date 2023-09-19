<?php

namespace App\Imports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Ingest;
use Illuminate\Support\Str;
use App\Models\HourListing;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TrainingImport implements ToModel, WithHeadingRow
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
             return new Training([
                 'source'                    => $row['data_source'],
                 'course_name'               => $row['course_name'],
                 'date'                      => Date::excelToDateTimeObject($row['start_date']),
                 'primary_subject'           => $row['primary_subject'],
                 'detailed_subject'          => $row['detailed_subject'],
                 'account_id'                => $row['account_id'],
                 'ingest_id'                 => $this->ingest->id
             ]);
    }

    public function headingRow() {
        return 6;
    }
}
