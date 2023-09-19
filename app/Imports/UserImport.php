<?php

namespace App\Imports;

use App\Models\RccUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Ingest;
use Illuminate\Support\Str;
use App\Models\HourListing;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class UserImport implements ToModel, WithHeadingRow
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
             return new RccUser([
                 'account_id'        => $row['vcn'],
                 'role'              => $row['job'],
                 'is_active'         => $row['active'],
                 'last_login'        => new Carbon($row['last_login']),
                 'ingest_id'         => $this->ingest->id
            ]);
    }
}
