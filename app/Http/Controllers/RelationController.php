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
        $status = DB::table('status')->get(); //get all the existing status from database
        $cars = DB::table('cars')->get(); //get all the registered cars in the database

        // return the component to be displayed with it's required data
        return Inertia::render('Relation/Show', ['status' => $status, 'cars' => $cars]);
    }

    public function search(Request $request)
    {
        $pattern = $request->input('pattern');
        $nisha = DB::table('nisha')->select('id')
            ->where('partnumber', 'like', "$pattern%")->get();

        $pattern = DB::table('patterns')->select('id')
            ->where('serial', 'like', "$pattern%")->get();

        $pattern_ids = [];

        foreach ($nisha as $key => $value) {
            array_push($pattern_ids, $value->id);
        }

        $similar = DB::table('similars')->select('nisha_id', 'pattern_id')
            ->whereIn('pattern_id', $pattern_ids)->get();

        $similar_ids = [];

        foreach ($similar as $key => $value) {
            array_push($similar_ids, ['pattern_id' => $value->pattern_id, 'nisha_id' => $value->nisha_id]);
        }

        return $similar;
    }
}
