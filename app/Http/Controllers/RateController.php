<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RateController extends Controller
{
    public function index()
    {
        $rate = DB::table('rates')
        ->orderBy('amount', 'asc')
        ->get();
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

        $rate = new Rate();
        $rate->amount = $amount;
        $rate->status = $status;
        $rate->save();
    }

    public function edit($rate)
    {
        $rates = DB::table('rates')
        ->orderBy('amount', 'asc')
        ->get();
        $rate = Rate::find($rate);
        return Inertia::render('Rates/Partials/Update', ['rates' => $rates, 'rate' => $rate]);
    }

    public function update(Request $request, $rate)
    {
        $amount = $request->input('amount');
        $status = $request->input('status');
        $rate = Rate::find($rate);
        $rate->amount = $amount;
        $rate->status = $status;
        $rate->save();
    }
}
