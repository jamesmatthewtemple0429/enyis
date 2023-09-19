<?php

namespace App\Imports;

use App\Models\Call;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Ingest;
use Illuminate\Support\Str;
use App\Models\HourListing;
use Carbon\Carbon;
use App\Models\Member;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CallImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    private $members;

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
            case 'St. Lawrence':
            case 'Jefferson':
            case 'Lewis':
                return 'CENY';
            default:
                return 'UKN';
        }
    }

    private function getTerritory($county)
    {
        $county = ucwords($county);

        switch ($county) {
            default:
                return 0;

            case 'Orange':
            case 'Putnam':
            case 'Ulster':
            case 'Dutchess':
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
    public function __construct(protected $ingest) {
        $this->members = Member::all();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['assignedto'] !== null && Str::contains($row['natureofcalltext'],'new disaster') || Str::contains($row['natureofcall'], "Follow up on event with no RC Care case")) {
            $addressParts = explode(", ", $row['eventaddress']);
            $streetParts = explode(" ", $addressParts[0]);
            unset($streetParts[0]);

            $location = implode(" ", $streetParts) . ", " . $addressParts[1] . ", NY";

            $nameParts = explode(" ", $row['assignedto']);
            $name = $nameParts[1] . ", " . $nameParts[0];

            return new Call([
                'call_id'           => $row['callid'],
                'location' => hash('sha256', $location),
                'do'       => hash('sha256',$name),
                'reasonforclosure' => $row['reasonforeventclosure'],
                'happened_at'       => ($row['eventdateandtime'] === null) ? null : new Carbon($row['eventdateandtime']),
                'called_at'         => new Carbon($row['dateandtimeofcall']),
                'acknowledged_at'   => new Carbon($row['acknowledgedtimestamp']),
                'suspended_at'      => ($row['eventsuspendedtimestamp'] === null) ? null : new Carbon($row['eventsuspendedtimestamp']),
                'on_scene_at'         => ($row['onscenetimestamp'] === null) ? null :new Carbon($row['onscenetimestamp']),
                'off_scene_at'         => ($row['offscenetimestamp'] === null) ? null :new Carbon($row['offscenetimestamp']),
                'assigned_at'   => ($row['assignedtimestamp'] === null) ? null :new Carbon($row['assignedtimestamp']),
                'closed_at'         => ($row['closedtimestamp'] === null) ? null :new Carbon($row['closedtimestamp']),
                'caller_type'       => $row['typeofcaller'],
                'disaster_address' => $row['eventaddress'],
                'address'           => $addressParts[0],
                'city'              => $addressParts[1],
                'event_type'        => $row['eventtype'],
                'county'            => $county = str_replace('St.','Saint', str_replace(" County", "", $row['countyname'])),
                'chapter'           => $this->getChapter($county),
                'territory'         => $this->getTerritory($county),
                'status'            => $row['eventstatus'],
                'is_suspended'      => ($row['suspendcall'] === 'Yes') ? true : false,
                'agency_type'       => $row['agencytype'],
                'has_iir'           => ($row['iircreated'] === "Yes") ? true : false,
                'iir_at'         => ($row['iircreated'] === "No") ? null : new Carbon($row['iircreateddateandtime']),
                'is_closed'     => ($row['closeevent'] === "Yes") ? true : false,
                'regional_resources' => ($row['addedregionalresources'] === "Yes") ? true : false,
                'activate_dat' => ($row['activatedat'] === "Yes") ? true : false,
                'nature'  => trim($row['natureofcalltext']),
                'ingest_id'     => $this->ingest->id
            ]);
        }
        /*
        */
    }

    public function batchSize() : int {
        return 500;
    }

}
