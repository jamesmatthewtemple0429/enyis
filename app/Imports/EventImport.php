<?php

namespace App\Imports;

use App\Models\RccEvent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Ingest;
use Illuminate\Support\Str;
use App\Models\HourListing;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class EventImport implements ToModel, WithHeadingRow
{
    public function __construct(protected $ingest) {

    }

    private function getChapter($county) {
        $county = ucwords($county);

        switch($county) {
            case 'Orange':
            case 'Putnam':
            case 'Ulster':
            case 'Dutchess':
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
            case 'Dutchess':
            case 'Greene':
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
        $streetParts = explode(" ", $row['street']);
        unset($streetParts[0]);
        $location = implode(" ", $streetParts) . ", " . $row['city'] . ", NY";

        return new RccEvent([
                 'location'        => hash('sha256',$location),
            'location_name'        => $location,
            'county'            => $county = str_replace('St.','Saint', str_replace(" County", "", $row['county'])),
                 'chapter'           => $this->getChapter($county),
                 'territory'         => $this->getTerritory($county),
                 'city' => $row['city'],
                 'name'           => $row['event_event'],
                 'type'          => $row['event_type'],
                 'entered_at'    => new Carbon($row['event_created_date']),
                 'happened_at'   => new Carbon($row['date_of_event']),
                 'ingest_id' => $this->ingest->id
            ]);
    }
}
