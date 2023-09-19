<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SituationalAwarenessController extends Controller
{
    public function index() {
        $sections = collect([
            [
                'name'          => 'Announcements',
                'description'   => 'Announcements may be used to share important changes to the program with the Workforce. Announcements may be viewed from Information System, or from Reports.',
                'url'           => route('announcements.index')
            ],
            [
                'name'          => 'States of Emergency',
                'description'   => 'States of Emergency are issued by Government Agencies in response to Natural Disasters. State of Emergencies are available to the workforce via reports.',
                'url'           => route('statesofemergency.index')
            ],
            [
            'name'          => 'Travel Warnings',
            'description'   => 'Travel Warnings are issued by Government Agencies in response to Natural Disasters. Travel Warnings are available to the workforce via reports.',
            'url'           => route('travelbans.index')
            ],
            [
                'name'          => 'Ground Stops',
                'description'   => 'Ground Stops are issued by local, regional, or national Leadership in response to Natural Disasters or other unsafe conditions. During a ground stop, responders may not be asked to respond in person.',
                'url'           => route('groundstops.index')
            ],
        ])->chunk(3);

        return Inertia::render("SituationalAwareness",[
            'sectionChunks' => $sections
        ]);
    }
}
