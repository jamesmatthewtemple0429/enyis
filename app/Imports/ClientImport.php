<?php

namespace App\Imports;

use App\Models\RccClient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Ingest;
use Illuminate\Support\Str;
use App\Models\HourListing;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ClientImport implements ToModel, WithHeadingRow
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
        $streetParts = explode(" ", $row['pre_disaster_street']);

        unset($streetParts[0]);

        $location = implode(" ", $streetParts) . ", " . $row['pre_disaster_city'] . ", NY";


             return new RccClient([
                 'name'              => $row['clients_id'],
                 'age'               => $row['age'],
                 'entered_at'        => new Carbon($row['created_date']),
                 'is_military'       => !(($row['military_affiliation'] === "Not Applicable" || $row['military_affiliation'] === null)),
                 'location'            => hash('sha256',$location),
                 'ingest_id'         => $this->ingest->id,
            ]);
    }
}
