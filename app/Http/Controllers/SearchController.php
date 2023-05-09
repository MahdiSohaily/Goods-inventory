<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $pattern = $request->input('pattern');
        $user = DB::table('nisha')->where('partnumber', 'like', "$pattern%") ->get();
        return response()->json([$user]);
    }
}
