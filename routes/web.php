<?php

    use Barryvdh\DomPDF\Facade\Pdf;
    use Illuminate\Foundation\Application;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix("auth")->name("auth.")->namespace('Auth')->group(function() {
    Route::get('redirect','MicrosoftAuthController@redirect')->name('redirect');
    Route::get('handle','MicrosoftAuthController@handle')->name('handle');
});

Route::get('test', function() {
   dd(currentDos());
});
Route::prefix('utils')->group(function() {
    Route::get('distrolists',function() {
        return \App\Models\DistributionList::with('report')->whereAccess(1)->get();
    });
});

Route::post("distrolists", "DistributionListsController@signup")->name('distrolists.signup');
    Route::prefix('ingest/{password}')->namespace("Ingest")->group(function() {
        Route::get("volunteer_connection","VolunteerConnectionController@index");

        Route::get("outages","PowerOutagesController@create");
        Route::post("outages","PowerOutagesController@store");

        Route::get("rc_respond/iirs","IirsController@create");
        Route::post("rc_respond/iirs","IirsController@store");

        Route::get("rc_respond/schedules/do","DutyOfficerScheduleController@create");
        Route::post("rc_respond/schedules/do","DutyOfficerScheduleController@store");

        Route::get("rc_respond/schedules/dat/init","DatScheduleController@index");
        Route::get("rc_respond/schedules/dat","DatScheduleController@get");
        Route::get("rc_respond/schedules/dat/schedule","DatScheduleController@create");
        Route::post("rc_respond/schedules/dat/schedule","DatScheduleController@store");

        Route::get("rc_respond/schedules/do/shifts","DutyOfficerScheduleController@edit");
        Route::post("rc_respond/schedules/do/shifts","DutyOfficerScheduleController@update");


    });
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('roles','RolesController');
    Route::resource('rules','RulesController');
    Route::resource('issues','IssuesController');
    Route::resource('interims','InterimsController');
    Route::resource('counties','CountiesController');
    Route::get('reports/{report}/test','ReportsController@test')->name('reports.test');
    Route::resource('reports','ReportsController');
    Route::resource('reports.sections','SectionsController');
    Route::resource('distributionlists','DistributionListsController');

    Route::resource('sections.roles','SectionRolesController');
    Route::resource('sections.filters','SectionFiltersController');

    Route::prefix("system")->group(function() {
       Route::get("/", "SystemAdminController@index")->name("system.index");
    });

    Route::prefix("sitawareness")->group(function() {
        Route::get("/", "SituationalAwarenessController@index")->name("situationalawareness.index");
    });

    Route::prefix("sitmon")->group(function() {
      //  Route::get("/", "SituationMonitoringController@index")->name("situationmonitor.index");
    });

    Route::resource('announcements','AnnouncementsController');
    Route::resource('statesofemergency','StatesOfEmergencyController');
    Route::resource('travelbans','TravelBansController');
    //Route::resource('groundstops','GroundStopsController');
});

