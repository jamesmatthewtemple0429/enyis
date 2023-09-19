<?php

namespace App\Http\Controllers\Ingest;

use App\Http\Controllers\Controller;
use App\Models\Ingest;
use App\Models\OutageData;
use Illuminate\Http\Request;

class PowerOutagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('ingest.outages.create');
    }

    public function store(Request $request) {
        $ingest = Ingest::create(['name' => str_replace(' ', '',$request->company)]);

        $outagesArray = [];

        foreach(range(1,5) as $key) {
            if($request->get('company' . $key,'') !== '' && $request->get('company' . $key) !== null) {
                $outagesArray[] = [
                    'ingest_id' => $ingest->id,
                    'county'    => strtoupper($request->county),
                    'affected'    => $affected = (int) str_replace('Fewer than 5','0',$request->get('affected' . $key)),
                    'total_customers'    => $total = (int) str_replace(',','',$request->get('total' . $key)),
                    'percentage' => round(number_format(($affected/$total),5)*100,2),
                    'company'       => strtoupper($request->get('company' . $key))
                ];
            }
        }

        OutageData::insert($outagesArray);

        return redirect()->to("/ingest/1EasternNewYork/outages");
    }
}
