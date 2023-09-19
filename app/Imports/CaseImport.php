<?php

namespace App\Imports;

use App\Models\RccCase;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class CaseImport implements ToModel, WithHeadingRow
{
    public function __construct(protected $ingest) {

    }

    private function getChapter($county) {
        $county = ucwords($county);

        switch($county) {
            case 'Orange':
            case 'Putnam':
            case 'Ulster':
            case 'Duchess':
            case 'Greene':
            case 'Columbia':
                return 'HVC';
            case "Schoharie":
            case "Albany":
            case "Schenectady":
            case "Rensselaer":
            case 'Montgomery':
            case 'Fulton':
            case 'Hamilton':
            case 'Washington':
            case 'Saratoga':
            case 'Franklin':
            case 'Clinton':
            case 'Essex':
                return 'NENY';
            case 'Herkimer':
            case 'Onondaga':
            case 'Oswego':
            case 'Oneida':
            case 'Madison':
            case 'Saint Lawrence':
            case 'Jefferson':
            case 'Lewis':
                return 'CENY';
        }
    }

    private function getTerritory($county)
    {
        $county = ucwords($county);

        switch ($county) {
            case 'Orange':
            case 'Putnam':
            case 'Ulster':
            case 'Duchess':
            case 'Greene':
            case 'Columbia':
                return 1;
            case 'Madison':
            case 'Onondaga':
            case 'Oswego':
                return 2;
            case 'Oneida':
            case 'Herkimer':
            case 'Hamilton':
            case 'Montgomery':
            case 'Fulton':
            case 'Schoharie':
                return 3;
            case 'Lewis':
            case 'Jefferson':
            case 'Saint Lawrence':
            case 'Clinton':
            case 'Essex':
            case 'Franklin':
                return 4;
            case 'Albany':
            case 'Schenectady':
            case 'Rensselaer':
            case 'Washington':
            case 'Warren':
            case 'Washington':
            case 'Saratoga':
                return 5;
        }
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $disasterAddress = ($row['pre_disaster_unit']) ?
            $row['pre_disaster_street'] . ", " . $row['pre_disaster_unit'] . ", " . $row['pre_disaster_city'] :
            $row['pre_disaster_street'] . ", " . $row['pre_disaster_city'];

             return new RccCase([
                 'case_number'       => $row['case_number'],
                 'owner'             => $row['case_owner'],
                 'entered_at'        => new Carbon($row['datetime_opened']),
                 'event'             => $row['event'],
                 'virtual_response'  => $row['virtual_response'],
                 'disaster_address' => $disasterAddress,
                 'address'           => $row['pre_disaster_street'],
                 'unit'              => $row['pre_disaster_unit'],
                 'city'              => $row['pre_disaster_city'],
                 'county'            => $county = str_replace('St.','Saint', str_replace(" County", "", $row['county'])),
                 'chapter'           => $this->getChapter($county),
                 'territory'         => $this->getTerritory($county),
                 'amount_disbursed'  => $row['total_amount_disbursed'],
                 'ingest_id'        => $this->ingest->id,
                 'total_clients' => $row['count_of_payment_eligible'],
            ]);
    }
}
