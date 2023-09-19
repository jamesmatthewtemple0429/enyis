<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemAdminController extends Controller
{
    public function index() {
        $sections = collect([
            [
                'name'          => 'System Roles',
                'description'   => 'System Roles assign permissions to Volunteer Connection Members via Authorization Rules. System Roles are Region Wide Resources.',
                'url'           => route('roles.index')
            ],
            [
                'name'          => 'Authorization Rules',
                'description'   => 'Authorization Rules assign Positions or System Roles to Members, Positions, or Qualifications.',
                'url'           => route('rules.index')
            ],
            [
                'name'          => 'Counties',
                'description'   => 'Identify Counties that Information System will monitor, including DCS Territory and Chapter Assignments.',
                'url'           => route('counties.index')
            ],
            [
                'name'          => 'Reports',
                'description'   => 'The Report tool allows Administrator to build custom reports, which can then be either ran manually, or sent automatically via distribution lists.',
                'url'           => route('reports.index')
            ],
            [
                'name'          => 'Distribution Lists',
                'description'   => 'Distribution Lists are used to automatically send Reports on a Time Schedule or when certain evens happen.',
                'url'           => route('distributionlists.index')
            ]
        ])->chunk(3);

        return Inertia::render("SystemAdmin",[
            'sectionChunks' => $sections
        ]);
    }
}
