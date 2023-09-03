<?php namespace App\Http\Controllers;
    use App\Models\County;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\StateOfEmergency;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use NunoMaduro\Collision\Adapters\Phpunit\State;
    use PHPUnit\Event\Telemetry\System;

    class StatesOfEmergencyController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $soes = StateOfEmergency::with('counties')->get();

            $newSoes = [];

            foreach($soes as $soe) {
                $newSoes[] = array_merge($soe->toArray(), [
                    'display_counties' => $soe->counties->pluck('name')->implode(", "),
                    'county_ids' => $soe->counties->pluck('id')
                ]);
            }

            return Inertia::render("StatesOfEmergency/Index",[
                'roles' => $newSoes
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("StatesOfEmergency/Create",[
                'countyChunks' => County::all()->groupBy('territory')->chunk(3)
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $soe = StateOfEmergency::create($request->except(['counties']));

            $soe->counties()->sync($request->counties);

            return redirect()->route('statesofemergency.index')
                ->with([
                    'flash.banner'  => 'The State of Emergency was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit($soe)
        {
            $soe = StateOfEmergency::find($soe);
            return Inertia::render("StatesOfEmergency/Edit",[
                'soe' => array_merge($soe->toArray(), ['county_ids' => $soe->counties->pluck('id')]),
                'countyChunks' => County::all()->groupBy('territory')->chunk(3)
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, $soe)
        {
            $soe = StateOfEmergency::find($soe);

                $soe->update($request->except(['counties','effective_at']));

            $soe->counties()->sync($request->counties);


            return redirect()->route('statesofemergency.index')
                ->with([
                    'flash.banner'  => 'The State of Emergency was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy($soe)
        {
            StateOfEmergency::find($soe)->delete();

            return redirect()->route('statesofemergency.index')
                ->with([
                    'flash.banner'  => 'The State of Emergency was deleted successfully!'
                ]);
        }
    }
