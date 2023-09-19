<?php

namespace App\Http\Controllers\Ingest;

use App\Http\Controllers\Controller;
use App\Models\InitialIncidentReport;
use Illuminate\Http\Request;

class IirsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('ingest.rcr.iirs');
    }

    public function store(Request $request) {
        InitialIncidentReport::firstOrCreate([
            'key' => hash('sha256',$request->date1 . ":" . $request->name1)
        ])->update([
            'entered_at' => $request->date1,
            'county'     => strtoupper(str_replace(' County','',str_replace('St.','Saint',$request->county1))),
            'name'      => $request->name1,
            'summary'   => $request->summary1,
        ]);

        InitialIncidentReport::firstOrCreate([
            'key' => hash('sha256',$request->date2 . ":" . $request->name2)
        ])->update([
            'entered_at' => $request->date2,
            'county'     => strtoupper(str_replace(' County','',str_replace('St.','Saint',$request->county2))),
            'name'      => $request->name2,
            'summary'   => $request->summary2,
        ]);

        InitialIncidentReport::firstOrCreate([
            'key' => hash('sha256',$request->date3 . ":" . $request->name3)
        ])->update([
            'entered_at' => $request->date3,
            'county'     => strtoupper(str_replace(' County','',str_replace('St.','Saint',$request->county3))),
            'name'      => $request->name3,
            'summary'   => $request->summary3,
        ]);
    }
}
