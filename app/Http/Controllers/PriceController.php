<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public function index()
    {
        return Inertia::render('Price/Show');
    }

    public function load(Request $request)
    {
        Validator::make($request->all(), [
            'customer' => 'required|string|exists:customers,id',
            'code' => 'required|string',

        ], [
            'required' => "The :attribute field can't be empty.",
        ])->validate();

        $customer = $request->input('customer');
        $completeCode = $request->input('code');

        $codes = explode("\n", $request->input('code'));
        $allCodeData = [];

        foreach ($codes as $key => $value) {
            $good = DB::table('nisha')->where('partNumber', $value)->first();
            if ($good) {
                array_push($allCodeData, ['result' => $this->getCodeData($good->id, $customer, $value), 'search' => $value]);
            } else {
                array_push($allCodeData, ['result' => null, 'search' => $value]);
            }
        }

        return Inertia::render('Price/Partials/Load', ['allCodeData' => $allCodeData, 'customer' => $customer, 'completeCode' => $completeCode]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'partnumber' => 'required|string|exists:nisha,partnumber'

        ], [
            'required' => "The :attribute field can't be empty.",
        ])->validate();

        DB::table('prices')->insert([
            'partnumber' => $request->input('partnumber'),
            'price' => $request->input('price'),
            'customer_id' => $request->input('customer'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $customer = $request->input('customer');
        $completeCode = $request->input('code');

        $codes = explode("\n", $request->input('code'));
        $allCodeData = [];

        foreach ($codes as $key => $value) {
            $good = DB::table('nisha')->where('partNumber', $value)->first();
            if ($good) {
                array_push($allCodeData, ['result' => $this->getCodeData($good->id, $customer, $value), 'search' => $value]);
            } else {
                array_push($allCodeData, ['result' => null, 'search' => $value]);
            }
        }

        return Inertia::render('Price/Partials/Load', ['allCodeData' => $allCodeData, 'customer' => $customer, 'completeCode' => $completeCode]);
    }

    public function getCodeData($code, $customer, $search)
    {

        $pattern_id = DB::table('similars')->where('nisha_id', $code)->first();
        $pattern = DB::table('patterns')->where('id', $pattern_id->pattern_id)->first();

        $all_relations = DB::table('similars')
            ->join('nisha', 'similars.nisha_id', '=', 'nisha.id')
            ->where('pattern_id', $pattern_id->pattern_id)->get();

        $cars = DB::table('patterncars')
            ->join('cars', 'patterncars.car_id', '=', 'cars.id')
            ->where('patterncars.pattern_id', $pattern_id->pattern_id)->get();

        $rates = DB::table('rates')
            ->orderBy('amount', 'asc')
            ->get();

        $good = DB::table('nisha')->where('id', $code)->first();
        $partNumber = substr($good->partnumber, 0, 5);

        $prices = DB::table('prices')
            ->join('customers', 'prices.customer_id', 'customers.id')
            ->where('prices.partnumber', 'like', "$partNumber%")
            ->orderBy('prices.created_at', 'desc')
            ->limit(4)
            ->get();

        return  [
            'search' => $search, 'code' => $code, 'pattern' => $good->partnumber,
            'relations' => $all_relations, 'customer' => $customer, 'cars' => $cars,
            'rates' => $rates, 'prices' => $prices, 'name' => $pattern->name
        ];
    }
}
