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
        $result = DB::table('nisha')->where('partnumber', 'like', "$pattern%")->get();
        return response()->json([$result]);
    }

    public function mobis(string $mobis = null)
    {
        $user = DB::table('nisha')->where('partnumber', '=', "$mobis%")->get();
        require_once 'simple_html_dom.php';
        echo $user;
    }
}
