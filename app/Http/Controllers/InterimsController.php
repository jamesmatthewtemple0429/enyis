<?php namespace App\Http\Controllers;
    use App\Models\Interim;
    use App\Models\InterimAssignment;
    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class InterimsController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $assignments = InterimAssignment::with('member')->get();

            return Inertia::render("Interims/Index",[
                'roles' => $assignments
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("Interims/Create",[
                'members' => Member::all()
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $role = InterimAssignment::create($request->all());


            return redirect()->route('interims.index')
                ->with([
                    'flash.banner'  => 'The Assignment was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(InterimAssignment $interim)
        {
            return Inertia::render("Interims/Edit",[
                'interim' => $interim,
                'members' => Member::all(),
                'memberName' => $interim->member->name
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, InterimAssignment $interim)
        {
            $interim->update($request->all());

            return redirect()->route('interims.index')
                ->with([
                    'flash.banner'  => 'The Interim Assignments was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(InterimAssignment $interim)
        {
            $interim->delete();

            return redirect()->route('interims.index')
                ->with([
                    'flash.banner'  => 'The Interim Assignment was deleted successfully!'
                ]);
        }
    }
