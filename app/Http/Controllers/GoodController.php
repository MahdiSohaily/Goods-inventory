<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodController extends Controller
{
    public function index () {
        $goods = DB::table('rates')
            ->select('amount', 'status')
            ->orderBy('amount', 'asc')
            ->get();
        return Inertia::render('Dashboard', ['goods' => $goods]);
    }
}
