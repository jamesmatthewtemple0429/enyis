<?php namespace App\Http\Controllers;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class IssuesController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $roles = SystemIssue::all();

            return Inertia::render("Issues/Index",[
                'roles' => $roles
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("Issues/Create");
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $role = SystemIssue::create([
                'application' => $request->application,
                'description' => $request->description
            ]);


            return redirect()->route('issues.index')
                ->with([
                    'flash.banner'  => 'The System Issue was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(SystemIssue $issue)
        {
            return Inertia::render("Issues/Edit",[
                'issue' => $issue
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, SystemIssue $issue)
        {
            $issue->update([
                'application' => $request->application,
                'description' => $request->description
            ]);

            return redirect()->route('issues.index')
                ->with([
                    'flash.banner'  => 'The Issue was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(SystemIssue $issue)
        {
            $issue->delete();

            return redirect()->route('issues.index')
                ->with([
                    'flash.banner'  => 'The Issue was marked resolved successfully!'
                ]);
        }
    }
