<?php namespace App\Http\Controllers;
    use App\Models\County;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\Report;
    use App\Models\Role;
    use App\Models\Section;
    use App\Models\SectionFilter;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class SectionFiltersController extends Controller
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
            $roles = SectionFilter::where('section_id',$section->id)->get();

            return Inertia::render("Reports/Sections/Filters/Index",[
                'roles' => $roles,
                'section' => $section,
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create(Section $section)
        {
            return Inertia::render("Reports/Sections/Filters/Create",[
                'section' => $section,
	            'fields' => $this->getModelFields()[$section->model]
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request, Section $section)
        {
            $filter = SectionFilter::create(array_merge(
                $request->all(),
                [
                    'section_id' => $section->id
                ])
            );

            return redirect()->route('sections.filters.index', $section)
                ->with([
                    'flash.banner'  => 'The Filter was created successfully!'
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
                    'url'           => route('reports.sections.index', $report)
                ];
            }

            if($section->type == 6) {
                $sections[] =                 [
                    'name'          => 'Data Filters',
                    'description'   => 'Sections are are dynamic areas of a report, which may be managed by Administrators.',
                    'url'           => route('reports.sections.index', $report)
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
        public function edit(Section $section, SectionFilter $filter)
        {
            return Inertia::render("Reports/Sections/Filters/Edit",[
                'section' => $section,
	            'filter' => $filter,
	            'fields' => $this->getModelFields()[$section->model]
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Section $section, SectionFilter $filter)
        {
            $filter->update($request->all());

            return redirect()->route('sections.filters.index', $section)
                ->with([
                    'flash.banner'  => 'The Filter was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Section $section, SectionFilter $filter)
        {
            $filter->delete();

            return redirect()->route('sections.filters.index', $section)
                ->with([
                    'flash.banner'  => 'The Filter was deleted successfully!'
                ]);
        }
    }
