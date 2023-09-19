<?php namespace App\Http\Controllers;
    use App\Models\County;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\PositionAssignment;
    use App\Models\Report;
    use App\Models\Role;
    use App\Models\Section;
    use App\Models\SectionFilter;
    use App\Models\SectionRole;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class SectionRolesController extends Controller
    {
        private function getModelNames() {
            $models = [];

            foreach( scandir(app_path('Models')) as $model) {
                if(Str::contains($model, ".php") &&
                    ! Str::contains($model, "InterimMember") &&
                    ! Str::contains($model, "Ingest") &&
                    ! Str::contains($model, "MemberRole") &&
                    ! Str::contains($model, "Permission") &&
                    ! Str::contains($model, "RoleUser") &&
                    ! Str::contains($model, "User")
                ) {
                    $models[] = Str::before($model, ".php");
                }
            }

            return $models;
        }

        private function getModelFields() {
            $fields = [];

            foreach( scandir(app_path('Models')) as $model) {
                if(Str::contains($model, ".php") &&
                    ! Str::contains($model, "InterimMember") &&
                    ! Str::contains($model, "Ingest") &&
                    ! Str::contains($model, "MemberRole") &&
                    ! Str::contains($model, "Permission") &&
                    ! Str::contains($model, "RoleUser") &&
                    ! Str::contains($model, "User")
                ) {
                    $noPhp = Str::before($model,".php");
                    $className = "App\\Models\\" . $noPhp;
                    $class = (new $className);

                    $fields[$noPhp] = $class->fields;
                }
            }

            return $fields;
        }
        /**
         * Display a listing of the resource.
         */
        public function index(Section $section)
        {
            $roles = SectionRole::orderBy('priority')->get();

            return Inertia::render("Reports/Sections/Roles/Index",[
                'roles' => $roles,
                'section' => $section,
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create(Section $section)
        {
            $positions = [];

            foreach(PositionAssignment::all()->groupBy('name') as $name => $list) {
                if(! in_array($name, $positions)) {
                    array_push($positions, trim($name));
                }
            }

            return Inertia::render("Reports/Sections/Roles/Create",[
                'section' => $section,
                'positions' => $positions
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request, Section $section)
        {
          //  dd($request->all(), trim(preg_replace("/\([^)]+\)/","",$request->role)));
            $role = SectionRole::create(array_merge(
                $request->all(),
                [
                    'section_id' => $section->id
                ])
            );

            return redirect()->route('sections.roles.index', $section)
                ->with([
                        'flash.banner'  => 'The Role was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Section $section, SectionRole $role)
        {
            $positions = [];

            foreach(PositionAssignment::all()->groupBy('name') as $name => $list) {
                if(! in_array($name, $positions)) {
                    array_push($positions, trim($name));
                }
            }

            return Inertia::render("Reports/Sections/Roles/Edit",[
                'section' => $section,
	            'role' => $role,
                'positions' => $positions

            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Section $section, SectionRole $role)
        {
            $role->update($request->all());

            return redirect()->route('sections.roles.index', $section)
                ->with([
                    'flash.banner'  => 'The Role was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Section $section, SectionRole $role)
        {
            $role->delete();

            return redirect()->route('sections.roles.index', $section)
                ->with([
                    'flash.banner'  => 'The Role was deleted successfully!'
                ]);
        }
    }
