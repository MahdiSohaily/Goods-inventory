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
        return Inertia::render('Rates/Partials/Create');
    }

    public function store(Request $request)
    {
       $amount = $request->input('amount');
       $status = $request->input('status');

       $rate = new Rat
    }

    public function edit($rate)
    {
    }

    public function update(Request $request, $rate)
    {
    }
}
