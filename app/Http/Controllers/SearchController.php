<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        $rates = DB::table('rates')
            ->select('amount', 'status')
            ->orderBy('amount', 'asc')
            ->get();
        return Inertia::render('Dashboard', ['rates' => $rates]);
    }

    public function search(Request $request)
    {
        $pattern = $request->input('pattern');
        $user = DB::table('nisha')->where('partnumber', 'like', "$pattern%")->get();
        return response()->json([$user]);
    }

    public function mobis(string $mobis = null) {

    }
}
