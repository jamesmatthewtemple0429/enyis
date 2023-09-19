<?php

namespace App\Console\Commands;

use App\Models\DistributionList;
use App\Models\Report;
use App\Models\User;
use App\Models\WeatherAlert;
use App\Models\WeatherForecast;
use App\Models\WeatherZone;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Microsoft\Graph\Graph;

class TimeBasedDistributionList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:time-based-distribution-lists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function getTableName($model) {
        $model = str_replace(' ', '_',strtolower(Str::snake(Str::plural($model))));

        return $model;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(DistributionList::with(['subscriptions','subscriptions.member'])->where('type',1)->get() as $list) {
            $hour = now()->hour;
            $minute = now()->minute;
            $requiredMinute = $minute;
            $day = (now()->dayOfWeek == 0) ? 7 : now()->dayOfWeek-1;
            $newReport = false;

            if($list->frequency == 1 && $hour == $list->time && $minute == $requiredMinute) {
                $report = $this->generateReport($list);
                $newReport = true;
            } else if($list->frequency == 2 && $day == $list->day && $hour == $list->time && $minute == $requiredMinute) {
                $report = $this->generateReport($list);
                $newReport = true;
            } else if($list->frequency == 3 && now()->day == $list->date && $hour == $list->time && $minute == $requiredMinute) {
                $report = $this->generateReport($list);
                $newReport = true;
            }

            if($newReport) {
                $pdfContents = base64_encode(Storage::disk("reports")->get($report->uuid->toString() . ".pdf"));

                $primaryEmails = [];

                foreach($list->subscriptions as $subscription) {
                    $primaryEmails[] = ['emailAddress' => [
                        'address' => $subscription->member->email,
                    ]];
                }

                $user = User::first();

                $graph = new Graph();
                $graph->setBaseUrl("https://graph.microsoft.com/")
                    ->setApiVersion("beta")
                    ->setAccessToken($user->access_token);


                $mailBody = json_encode([
    "subject" => $list->report->name . " - " . now()->format('M d, Y'),
    "replyTo" => [
        ['emailAddress' =>
            [
            'address' => "easternnydat@americanredcross.onmicrosoft.com"
            ]
        ]
    ],
    "body"=>[
                    "contentType"=>"HTML",
        "content"=> "Please find the attached <b>" . $list->report->name . "</b> for " . now()->format('M d, Y') . ". If you have any questions about this report, please reach out to the Regional Disaster Action Team Leadership.<br /><br />Unable to access the attachment? <a href='" . url('reports/' . $report->uuid->toString() . '.pdf') ."'>Click here to access the document.</a>"
    ],
    "bccRecipients"=> $primaryEmails
    ]);

                //                     "Attachments" => [
                //                        [
                //                            "@odata.type" =>  "#microsoft.graph.fileAttachment",
                //                            "name" => "attachment.pdf",
                //                            "contentType" => "text/pdf",
                //                            "contentBytes" => $pdfContents
                //                        ]
                //                    ],
                $distroMessage = $graph->createRequest("POST", "/me/messages")
                    ->attachBody($mailBody)
                    ->execute()
                    ->getBody();


                $attachmentBody = json_encode([
                    "@odata.type" => "#microsoft.graph.fileAttachment",
                      "name" =>  $list->report->name . " - " . now()->format('M d, Y'),
                      "contentBytes" => $pdfContents
                ]);

                $graph->createRequest("POST", "/me/messages/" . $distroMessage['id'] . "/attachments")
                    ->attachBody($attachmentBody)
                    ->execute()
                    ->getBody();

                $graph->createRequest("POST", "/me/messages/" . $distroMessage['id'] . "/send")
                    ->execute()
                    ->getBody();
            }

        }
    }

    private function generateReport($list) {
        $report = Report::with(['sections','sections.filters','sections.roles'])->whereId($list->report_id)->first();
        $publication = $list->publications()->create(['uuid' => Str::orderedUuid()]);

        $sectionData = [];
        foreach($report->sections as $section) {
            if($section->type == 3) {
                $weatherAlerts = WeatherAlert::whereIn('message_type',['Alert','Update'])
                    ->where('expires_at','>',now());

                if($section->territory) {
                    $weatherAlerts = $weatherAlerts->where('territory', $section->territory);
                }

                if($section->territory) {
                    $weatherAlerts = $weatherAlerts->where('county', $section->county);
                }

                $sectionData[$section->id] = $weatherAlerts->get()->chunk(3);
            }

            if($section->type == 4) {

                $counties = new \App\Models\County;

                if($section->territory) {
                    $counties = $counties->where('territory', $section->territory);
                }

                if($section->county) {
                    $counties = $counties->where('name', $section->county);
                }

                $counties = $counties->get();
                $countyNames = $counties->pluck('name')->toArray();

                $wxZones = WeatherZone::whereIn('county',$countyNames)->get()->pluck('wx_id')->toArray();

                $wxForecasts = WeatherForecast::all();

                $forecastArray = [];

                foreach($counties as $county) {
                    $zoneIds = $county
                        ->wxZones
                        ->pluck('wx_id')
                        ->unique()
                        ->toArray();

                    $xForecasts = [];

                    foreach($zoneIds as $zone) {
                        $xForecasts = array_merge($xForecasts, $wxForecasts
                            ->where('wx_id', $zone)
                            ->groupBy('wx_id')->toArray());
                    }

                    $filteredForecasts = $xForecasts;

                    $realForecasts = [];

                    foreach($filteredForecasts as $zone => $forecasts) {
                        $realForecasts[] = array_slice($forecasts, 0, 6);
                    }
                    $forecastArray[ucwords(strtolower($county->name))] = Arr::flatten($realForecasts,1);
                }

                $sectionData[$section->id] = $forecastArray;
            }

            if($section->type == 6) {
                //$model = DB::table($this->getTableName($section->model));
                $modelName = "\\App\\Models\\" . $section->model;
                $model = new $modelName;

                foreach($section->filters as $filter) {
                    if($filter->operator == 'gTime') {
                        $model = $model->where($filter->name, '>', now());
                    } else if ($filter->operator == 'lTime') {
                        $model = $model->where($filter->name, '<', now());
                    } else if($filter->operator == 'in') {
                        $model = $model->whereIn($filter->name, explode(",", $filter->value));
                    } else if($filter->operator == 'null') {
                        $model = $model->where($filter->name, null);
                    } else {
                        $model = $model->where($filter->name, $filter->operator, $filter->value);
                    }
                }

                $array = [];

                foreach($model->get() as $record) {
                    $array[] = json_decode(json_encode($record), true);
                }

                $sectionData[$section->id] = $array;
            }
        }

        $pdf = Pdf::loadView('test',[
            'report'    => $report,
            'sectionData' => $sectionData
        ]);


        file_put_contents('./storage/app/reports/' . $publication->uuid->toString(). ".pdf", $pdf->output());

        return $publication;
    }
}
