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
                'description'   => 'System Roles assign permissions to Volunteer Connection Members via Authorization Rules. System Roles are Region Wide Resources.',
                'url'           => route('announcements.index')
            ],
            [
                'name'          => 'States of Emergency',
                'description'   => 'Authorization Rules assign Positions or System Roles to Members, Positions, or Qualifications.',
                'url'           => route('statesofemergency.index')
            ],
            [
            'name'          => 'Travel Bans',
            'description'   => 'Authorization Rules assign Positions or System Roles to Members, Positions, or Qualifications.',
            'url'           => route('travelbans.index')
            ],
            [
                'name'          => 'Ground Stops',
                'description'   => 'Authorization Rules assign Positions or System Roles to Members, Positions, or Qualifications.',
                'url'           => route('groundstops.index')
            ],
        ])->chunk(3);

        return Inertia::render("SituationalAwareness",[
            'sectionChunks' => $sections
        ]);
    }
}
