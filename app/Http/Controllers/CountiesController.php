<?php namespace App\Http\Controllers;
    use App\Models\County;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class CountiesController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $roles = County::all();

            return Inertia::render("Counties/Index",[
                'roles' => $roles
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("Counties/Create");
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $attributes = $request->all();

            $attributes['name'] = strtoupper($attributes['name']);

            $county = County::create($attributes);


            return redirect()->route('counties.index')
                ->with([
                    'flash.banner'  => 'The County was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(County $county)
        {
            return Inertia::render("Counties/Edit",[
                'county' => $county
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, County $county)
        {
            $attributes = $request->all();

            $attributes['name'] = strtoupper($attributes['name']);

            $county->update($attributes);

            return redirect()->route('counties.index')
                ->with([
                    'flash.banner'  => 'The County was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(County $county)
        {
            $county->delete();

            return redirect()->route('counties.index')
                ->with([
                    'flash.banner'  => 'The County was deleted successfully!'
                ]);
        }
    }
