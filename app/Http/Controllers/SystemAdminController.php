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
            ]
        ])->chunk(3);

        return Inertia::render("SystemAdmin",[
            'sectionChunks' => $sections
        ]);
    }
}
