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
        return Inertia::render('Rates/Show', ['rates' => $rate]);
    }

    public function create()
    {
        $rate = DB::table('rates')->get();
        return Inertia::render('Rates/Partials/Create', ['rates' => $rate]);
    }

    public function store(Request $request)
    {
        # code...
    }

    public function edit($rate)
    {
    }

    public function update(Request $request, $rate)
    {
    }
}
