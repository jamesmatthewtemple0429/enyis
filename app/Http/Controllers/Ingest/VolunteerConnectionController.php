<?php

namespace App\Http\Controllers\Ingest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VolunteerConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ingest.vcn.index');
    }
}
