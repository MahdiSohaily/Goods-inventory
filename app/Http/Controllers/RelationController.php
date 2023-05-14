<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelationController extends Controller
{
    public function index()
    {
        $status = DB::table('status')->get();
        $cars = DB::table('cars')->get();
        return Inertia::render('Relation/Show', ['status' => $status, 'cars' => $cars]);
    }
}
