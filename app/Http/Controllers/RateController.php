<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RateController extends Controller
{
    public function index()
    {
        $rate = DB::table('rates')->get();
        Inertia::render('Rates/Show', ['rates' => $rate]);
    }
}
