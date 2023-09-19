<?php namespace App\Http\Controllers;
    use App\Models\County;
    use App\Models\TravelEdict;
    use Illuminate\Http\Request;
    use Inertia\Inertia;

    class TravelBansController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $soes = TravelEdict::with('counties')->get();

            $newSoes = [];

            foreach($soes as $soe) {
                $newSoes[] = array_merge($soe->toArray(), [
                    'display_counties' => $soe->counties->pluck('name')->implode(", "),
                    'county_ids' => $soe->counties->pluck('id')
                ]);
            }

            return Inertia::render("TravelEdicts/Index",[
                'roles' => $newSoes
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("TravelEdicts/Create",[
                'countyChunks' => County::all()->groupBy('territory')->chunk(3)
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $travelEdict = TravelEdict::create($request->except(['counties']));

            $travelEdict->counties()->sync($request->counties);

            return redirect()->route('travelbans.index')
                ->with([
                    'flash.banner'  => 'The Travel Warning was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit($travelBan)
        {
            $travelBan = TravelEdict::find($travelBan);
            return Inertia::render("TravelEdicts/Edit",[
                'edict' => array_merge($travelBan->toArray(), ['county_ids' => $travelBan->counties->pluck('id')]),
                'countyChunks' => County::all()->groupBy('territory')->chunk(3)
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, $travelEdict)
        {
            $travelEdict = TravelEdict::find($travelEdict);

                $travelEdict->update($request->except(['counties','effective_at']));

            $travelEdict->counties()->sync($request->counties);


            return redirect()->route('travelbans.index')
                ->with([
                    'flash.banner'  => 'The Travel Warning was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy($travelBan)
        {
            TravelEdict::find($travelBan)->delete();

            return redirect()->route('travelbans.index')
                ->with([
                    'flash.banner'  => 'The Travel Warning was deleted successfully!'
                ]);
        }
    }
