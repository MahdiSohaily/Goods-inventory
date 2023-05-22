<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public function index()
    {
        return Inertia::render('Price/Show');
    }

    public function create()
    {
        $code = '553113F650';
        $customer = 1;

        $code_id = DB::table('nisha')->select('id')->where('partnumber', $code)->first();
        $pattern_id = DB::table('similars')->where('nisha_id', $code_id->id)->first();
        $pattern = DB::table('patterns')->where('id', $pattern_id->pattern_id)->first();

        $all_relations = DB::table('similars')->where('pattern_id', $pattern_id->pattern_id)->get();
        $cars = DB::table('patterncars')
            ->join('cars', 'patterncars.car_id', '=', 'cars.id')
            ->where('patterncars.pattern_id', $pattern_id->pattern_id)->get();

        return Inertia::render(
            'Price/Partials/Load',
            ['code' => $code ,'pattern' => $pattern, 'relations' => $all_relations, 'customer' => $customer, 'cars' => $cars]
        );
    }

    public function load(Request $request)
    {
        Validator::make($request->all(), [
            'customer' => 'required',
            'code' => 'required',
        ], [
            'required' => "The :attribute field can't be empty.",
        ])->validate();

        $code = $request->input('code');
        $customer = $request->input('customer');

        $code_id = DB::table('nisha')->select('id')->where('partnumber', $code)->first();
        $pattern = DB::table('similars')->where('nisha_id', $code_id->id)->first();

        $all_relations = DB::table('similars')->where('pattern_id', $pattern->pattern_id)->get();
        $cars = DB::table('patterncars')
            ->join('cars', 'patterncars.car_id', '=', 'cars.id')
            ->where('patterncars.pattern_id', $pattern->pattern_id)->get();

        return Inertia::render(
            'Price/Partials/Load',
            ['pattern' => $pattern, 'relations' => $all_relations, 'customer' => $customer, 'cars' => $cars]
        );
    }
}
