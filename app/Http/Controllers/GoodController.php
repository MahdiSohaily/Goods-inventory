<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodController extends Controller
{
    public function index()
    {
        $goods = DB::table('nisha')
            ->limit(10)
            ->orderBy('id', 'asc')
            ->get();
        return Inertia::render('Goods/Show', ['goods' => $goods]);
    }
}
