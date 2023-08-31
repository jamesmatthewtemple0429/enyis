<?php

use Illuminate\Foundation\Application;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix("auth")->name("auth.")->namespace('Auth')->group(function() {
    Route::get('redirect','MicrosoftAuthController@redirect')->name('redirect');
    Route::get('handle','MicrosoftAuthController@handle')->name('handle');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('roles','RolesController');
    Route::resource('rules','RulesController');
    Route::resource('issues','IssuesController');
    Route::resource('interims','InterimsController');

    Route::prefix("system")->group(function() {
       Route::get("/", "SystemAdminController@index")->name("system.index");
    });

    Route::prefix("sitawareness")->group(function() {
        Route::get("/", "SituationalAwarenessController@index")->name("situationalawareness.index");
    });

    Route::resource('announcements','AnnouncementsController');
    Route::resource('statesofemergency','StatesOfEmergencyController');
    Route::resource('travelbans','TravelBansController');
    Route::resource('groundstops','GroundStopsController');
});

