<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MemberImport implements ToModel, WithHeadingRow
{
    private function getChapter($county) {
        $county = ucwords(strtolower($county));

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
        $county = ucwords(strtolower($county));

        switch ($county) {
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

    private function format_number($number) {
        $number = str_replace("(","",str_replace(")","",str_replace("-","", $number)));

        return (strlen($number) == 11) ? "+$number" : "+1$number";
    }

    public function __construct(protected $ingest) {

    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['dis_responder'] === 'Yes') {
            return new Member([
                'name'              => $row['account_name'],
                'status'            => $row['current_status'],
                'email'             => $row['email'],
                'email_key'         => $row['email'],
                'cell_phone'        => $this->format_number($row['cell_phone']),
                'second_email'      => $row['second_email'],
                'second_email_key'  => $row['second_email'],
                'county'            => $county = strtoupper(str_replace('St.','Saint', str_replace(' County','',$row['county_of_residence']))),
                'territory'         => $this->getTerritory($county),
                'chapter'           => $this->getChapter($county),
                'member_number'     => $row['member_number'],
                'account_id'        => $row['account_id'],
                'availability'      => $row['geog_availability'],
                'available_now'     => ($row['available_now'] === "Yes") ? true : false,
                'ingest_id'         => $this->ingest->id,
            ]);
        }
    }

    public function headingRow() {
        return 4;
    }
}
