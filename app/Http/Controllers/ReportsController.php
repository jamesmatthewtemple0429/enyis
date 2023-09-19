<?php namespace App\Http\Controllers;
    use App\Models\Call;
    use App\Models\Interim;
    use App\Models\RccCase;
    use App\Models\RccEvent;
    use App\Models\Shift;
    use App\Models\WeatherAlert;
    use App\Models\Report;
    use App\Models\WeatherForecast;
    use App\Models\SystemIssue;
    use App\Models\WeatherZone;
    use Barryvdh\DomPDF\Facade\Pdf;
    use Illuminate\Http\Request;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;
    use PHPUnit\Event\Telemetry\System;

    class ReportsController extends Controller
    {

        private function getModelNames()
        {
            $models = [];

            foreach ( scandir(app_path('Models')) as $model ) {
                if ( Str::contains($model, ".php") &&
                    !Str::contains($model, "InterimMember") &&
                    !Str::contains($model, "Ingest") &&
                    !Str::contains($model, "MemberRole") &&
                    !Str::contains($model, "Permission") &&
                    !Str::contains($model, "RoleUser")
                ) {
                    $models[] = Str::before($model, ".php");
                }
            }

            return $models;
        }

        /**
         * Display a listing of the resource.
         */
        public function index()
        {

            $roles = Report::all();

            return Inertia::render("Reports/Index", [
                'roles' => $roles
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("Reports/Create");
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $report = Report::create([
                'name' => $request->name,
                'description' => $request->description
            ]);


            return redirect()->route('reports.show', $report)
                ->with([
                    'flash.banner' => 'The Report was created successfully!'
                ]);
        }

        public function test($report)
        {
            $report = \App\Models\Report::with(['sections', 'sections.filters', 'sections.roles'])->whereId($report)->first();

            $sectionData = [];
            foreach ( $report->sections as $section )
                if ( $section->type == 2 ) {
                    $sectionData[$section->id] = [
                        'sv' => currentDos()['supervisor'],
                        'primaries' => Shift::with('member')->where('account_id','!=',null)->whereType(1)->whereBetween('starts_at', [now()->setTime(0, 0, 0), now()->setTime(23,59,0)])->get(),
                        'backups' => Shift::with('member')->where('account_id','!=',null)->whereType(2)->whereBetween('starts_at', [now()->setTime(0, 0, 0), now()->setTime(23,59,0)])->get(),
                    ];
                }
            if ( $section->type == 3 ) {
                $weatherAlerts = WeatherAlert::whereIn('message_type', ['Alert', 'Update'])
                    ->where('expires_at', '>', now());

                if ( $section->territory ) {
                    $weatherAlerts = $weatherAlerts->where('territory', $section->territory);
                }

                if ( $section->territory ) {
                    $weatherAlerts = $weatherAlerts->where('county', $section->county);
                }

                $sectionData[$section->id] = $weatherAlerts->get()->chunk(3);
            }

            if ( $section->type == 4 ) {

                $counties = new \App\Models\County;

                if ( $section->territory ) {
                    $counties = $counties->where('territory', $section->territory);
                }

                if ( $section->county ) {
                    $counties = $counties->where('name', $section->county);
                }

                $counties = $counties->get();
                $countyNames = $counties->pluck('name')->toArray();

                $wxZones = WeatherZone::whereIn('county', $countyNames)->get()->pluck('wx_id')->toArray();

                $wxForecasts = WeatherForecast::all();

                $forecastArray = [];

                foreach ( $counties as $county ) {
                    $zoneIds = $county
                        ->wxZones
                        ->pluck('wx_id')
                        ->unique()
                        ->toArray();

                    $xForecasts = [];

                    foreach ( $zoneIds as $zone ) {
                        $xForecasts = array_merge($xForecasts, $wxForecasts
                            ->where('wx_id', $zone)
                            ->groupBy('wx_id')->toArray());
                    }

                    $filteredForecasts = $xForecasts;

                    $realForecasts = [];

                    foreach ( $filteredForecasts as $zone => $forecasts ) {
                        $realForecasts[] = array_slice($forecasts, 0, 6);
                    }
                    $forecastArray[ucwords(strtolower($county->name))] = Arr::flatten($realForecasts, 1);
                }

                $sectionData[$section->id] = $forecastArray;
            }

            if ( $section->type == 6 ) {
                //$model = DB::table($this->getTableName($section->model));
                $modelName = "\\App\\Models\\" . $section->model;
                $model = new $modelName;

                foreach ( $section->filters as $filter ) {
                    if ( $filter->operator == 'gTime' ) {
                        $model = $model->where($filter->name, '>', now());
                    } else if ( $filter->operator == 'lTime' ) {
                        $model = $model->where($filter->name, '<', now());
                    } else if ( $filter->operator == 'in' ) {
                        $model = $model->whereIn($filter->name, explode(",", $filter->value));
                    } else if ( $filter->operator == 'null' ) {
                        $model = $model->where($filter->name, null);
                    } else if ( $filter->operator == 'day' ) {
                        $model = $model->where($filter->name, now()->subDays($filter->value));
                    } else if ( $filter->operator == 'yesterday' ) {
                        $start = now()->subDay()->setTime(0, 0, 0);
                        $end = now()->setTime(0, 0, 0);

                        $model = $model->whereBetween($filter->name, [$start, $end]);
                    } else if ( $filter->operator == 'date' ) {
                        $model = $model->where($filter->name, new Carbon($request->value));
                    } else {
                        $model = $model->where($filter->name, $filter->operator, $filter->value);
                    }
                }

                $array = [];

                foreach ( $model->get() as $record ) {
                    $array[] = json_decode(json_encode($record), true);
                }

                $eventIds = [];

                if ( $section->model == "RccEvent" ) {
                    foreach ( $array as $event ) {
                        $eventIds[] = $event['name'];
                    }

                    $cases = RccCase::whereIn('event', $eventIds)
                        ->get()
                        ->groupBy('event');


                    $newEvents = [];
                    $processEvents = [];

                    foreach ( $array as $event ) {
                        $totalCases = 0;
                        $totalDisbursed = 0;

                        foreach ( $cases as $e => $c ) {

                            if ( $event['name'] == $e ) {
                                foreach ( $c as $case ) {
                                    $totalCases++;
                                    $totalDisbursed += $case->amount_disbursed;
                                }

                                if ( !in_array($event['name'], $processEvents) ) {
                                    if ( $e === $event['name'] ) {
                                        $newEvents[] = array_merge($event, [
                                            'total_cases' => $totalCases,
                                            'total_disbursed' => "$" . $totalDisbursed
                                        ]);

                                        $processEvents[] = $event['name'];

                                    }
                                }
                            }
                        }
                    }

                    $sectionData[$section->id] = $newEvents;
                } else {
                    $sectionData[$section->id] = $array;
                }
            }
         //   dd($sectionData, RccEvent::where('entered_at', now()->subDay()->setTime(0,0,0))->get());

            $pdf = Pdf::loadView('test',[
                'report'    => $report,
                'sectionData' => $sectionData
            ]);

            return $pdf->stream('invoice.pdf');
        }

        public function show(Report $report) {
            $sections = collect([
                [
                    'name'          => 'Basic Information',
                    'description'   => 'Manage the name and other information related to this report.',
                    'url'           => route('reports.edit', $report)
                ],
                [
                    'name'          => 'Report Sections',
                    'description'   => 'Sections are are dynamic areas of a report, which may be managed by Administrators.',
                    'url'           => route('reports.sections.index', $report  )
                ]
            ])->chunk(3);


            return Inertia::render("Reports/Show",[
                'sectionChunks' => $sections
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Report $report)
        {
            return Inertia::render("Reports/Edit",[
                'report' => $report
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Report $report)
        {
            $report->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return redirect()->route('reports.index')
                ->with([
                    'flash.banner'  => 'The Report was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Report $report)
        {
            $report->delete();

            return redirect()->route('reports.index')
                ->with([
                    'flash.banner'  => 'The Report was deleted successfully!'
                ]);
        }
    }
