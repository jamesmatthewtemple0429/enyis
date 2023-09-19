<?php namespace App\Http\Controllers;
    use App\Models\County;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\Report;
    use App\Models\Role;
    use App\Models\Section;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class SectionsController extends Controller
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
        public function index(Report $report)
        {
            $roles = Section::where('report_id', $report->id)->get();

            return Inertia::render("Reports/Sections/Index",[
                'roles' => $roles,
                'report' => $report,
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create(Report $report)
        {
            $territories = County::get('territory')->map(function($county) {
                return $county->territory;
            });

            $counties = County::all();

            return Inertia::render("Reports/Sections/Create",[
                'report' => $report,
                'territories' => $territories,
                'counties' => $counties,
                'models' => $this->getModelNames(),
                'fields' => $this->getModelFields()
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request, Report $report)
        {
            $section = Section::create(array_merge(
                $request->except(['fields']),
                [
                    'report_id' => $report->id,
                    'fields' => json_encode($request->fields)
                ])
            );

            return ($request->type <= 2) ? redirect()->route('reports.sections.index', ['report' => $report]) : redirect()->route('reports.sections.show', ['report' => $report, 'section' => $section])
                ->with([
                    'flash.banner'  => 'The Section was created successfully!'
                ]);
        }

        public function show(Report $report, Section $section) {
            $sections = [
                [
                    'name'          => 'Basic Information',
                    'description'   => 'Manage the name and other information related to this section.',
                    'url'           => route('reports.sections.edit', ['report' => $report, 'section' => $section])
                ]
            ];

            if($section->type == 5) {
                $sections[] = [
                    'name'          => 'Leadership Roles',
                    'description'   => 'Sections are are dynamic areas of a report, which may be managed by Administrators.',
                    'url'           => route('sections.roles.index', $section)
                ];
            }

            if($section->type == 6) {
                $sections[] =                 [
                    'name'          => 'Data Filters',
                    'description'   => 'Sections are are dynamic areas of a report, which may be managed by Administrators.',
                    'url'           => route('sections.filters.index', $section)
                ];
            }

            $sections = collect($sections)->chunk(3);


            return Inertia::render("Reports/Sections/Show",[
                'sectionChunks' => $sections
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Report $report, Section $section)
        {
            $territories = County::get('territory')->map(function($county) {
                return $county->territory;
            });

            $counties = County::all();

            return Inertia::render("Reports/Sections/Edit",[
                'report' => $report,
                'territories' => $territories,
                'counties' => $counties,
                'models' => $this->getModelNames(),
                'fields' => $this->getModelFields(),
                'section' => $section
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Report $report, Section $section)
        {
            $section->update(array_merge(
                $request->except(['fields']),
                [
                    'report_id' => $report->id,
                    'fields' => json_encode($request->fields)
                ]));

            return redirect()->route('reports.sections.index', $report)
                ->with([
                    'flash.banner'  => 'The Section was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Report $report, Section $section)
        {
            $section->delete();

            return redirect()->route('reports.sections.index', $report)
                ->with([
                    'flash.banner'  => 'The Section was deleted successfully!'
                ]);
        }
    }
