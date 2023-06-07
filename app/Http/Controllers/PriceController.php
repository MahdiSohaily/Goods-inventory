<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
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
        if ($request->input('customer')) {
            $this->validateRequest($request->all());
            $customer = $request->input('customer');
            $completeCode = $request->input('code');

            $explodedCodes = explode("\n", $request->input('code'));

            $results_arry = [
                'not_exist' => [],
                'not_in_relationship' => [],
                'in_relationship' => [],
            ];

            $similar_codes = []; //this array contains all the similar codes for the current item in exploded codes array

            foreach ($explodedCodes as $code) {
                $good = DB::table('nisha')->select('id')->where('partNumber', 'like', "$code%")->get();
                if ($good) {
                    array_push($similar_codes, $good);
                } else {
                    array_push($results_arry['not_exist'], $code);
                }
            }

            return $similar_codes;

            return Inertia::render('Price/Partials/Load', ['codes' => null, 'customer' => $customer, 'completeCode' => $completeCode]);
        } else {
            $this->validateRequest($request->all());

            return Inertia::render('Price/Show');
        }
    }

    public function validateRequest($all_data)
    {
        Validator::make($all_data, [
            'customer' => 'required|string|exists:customers,id',
            'code' => 'required|string',

        ], [
            'required' => "وارد کردن :attribute الزامی می باشد.",
        ], [
            'customer' => 'مشتری',
            'code' => 'کد'
        ])->validate();
    }

    public function info(Request $request)
    {
        $id = $request->input('id');
        $isInRelation = DB::table('similars')->select('pattern_id')->where('nisha_id', $id)->first();
        $info = false;
        if ($isInRelation) {

            $info = DB::table('patterns')
                ->join('status', 'status.id', '=', 'patterns.status_id')
                ->select('patterns.*', 'status.name AS  status_name')
                ->where('patterns.id', $isInRelation->pattern_id)
                ->first();
        }

        return $info;
    }

    public function getCodeData($code, $customer, $search)
    {
        $good = DB::table('nisha')->where('id', $code)->first();

        $pattern_id = DB::table('similars')->where('nisha_id', $code)->first();

        $pattern = $pattern_id ? DB::table('patterns')->where('id', $pattern_id->pattern_id)->first() : null;

        $all_relations =  $pattern_id ? DB::table('similars')
            ->join('nisha', 'similars.nisha_id', '=', 'nisha.id')
            ->where('pattern_id', $pattern_id->pattern_id)->get() : [$good];
        $existing = [];

        foreach ($all_relations as $key => $value) {
            $existing["$value->id"] = $this->exist($value->id);
        }

        $sorted = [];
        foreach ($existing as $key => $value) {
            $sorted[$key . 'z'] = $this->getMax($value);
        }

        arsort($sorted);

        $cars = $pattern_id ? DB::table('patterncars')
            ->join('cars', 'patterncars.car_id', '=', 'cars.id')
            ->where('patterncars.pattern_id', $pattern_id->pattern_id)->get() : null;

        $rates = DB::table('rates')
            ->orderBy('amount', 'asc')
            ->get();


        $partNumber = substr($good->partnumber, 0, 7);

        $estelam = DB::table('estelam')
            ->select('estelam.*', 'seller.name')
            ->join('seller', 'seller.id', 'estelam.seller')
            ->where('estelam.codename', 'like', "$partNumber%")
            ->limit(4)
            ->orderBy('time', 'desc')
            ->get();

        $prices = DB::table('prices')
            ->select('prices.*', 'customers.name', 'customers.last_name')
            ->join('customers', 'prices.customer_id', 'customers.id')
            ->where('prices.partnumber', 'like', "$partNumber%")
            ->orderBy('prices.created_at', 'desc')
            ->limit(4)
            ->get();

        $ordered_price = $pattern_id ? DB::table('patterns')
            ->select('price')
            ->where('id', "$pattern_id->pattern_id")
            ->first() : null;

        $display_relation = [];

        foreach ($all_relations as $key => $value) {
            $display_relation["$value->id"] = $value;
        }
        return  [
            'search' => $search, 'code' => $code, 'pattern' => $good->partnumber,
            'relations' => $display_relation, 'customer' => $customer, 'cars' => $cars,
            'rates' => $rates, 'prices' => $prices, 'name' => $pattern ? $pattern->name : 'Not in relation',
            'existing' => $existing, 'estelam' => $estelam, 'ordered_price' => $ordered_price, 'sorted' => $sorted
        ];
    }

    public function out($id)
    {
        $result =
            DB::table('exitrecord')
            ->select('qty')
            ->where('qtyid', $id)
            ->first();
        return $result;
    }

    public function exist($id)
    {
        $result =
            DB::table('qtybank')
            ->join('brand', 'brand.id', '=', 'qtybank.brand')
            ->select('qtybank.id', 'codeid', 'brand.name', 'qty')
            ->where('codeid', $id)
            ->get();
        $brands = [];
        $amount = [];

        foreach ($result as $key => $value) {
            $out = $this->out($value->id) ? (int) $this->out($value->id)->qty : 0;
            $value->qty = (int)($value->qty) - $out;

            array_push($brands, $value->name);
        }
        $brands = array_unique($brands);

        foreach ($brands as $key => $value) {
            $item = $value;
            $total = 0;
            foreach ($result as $key => $value) {
                if ($item == $value->name) {
                    $total += $value->qty;
                }
            }
            array_push($amount, $total);
        }
        $final = array_combine($brands, $amount);
        arsort($final);
        return $final;
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

    public function test($code = '445096')
    {
        $good = DB::table('nisha')->where('id', $code)->first();

        $pattern_id = DB::table('similars')->where('nisha_id', $code)->first();

        $pattern = $pattern_id ? DB::table('patterns')->where('id', $pattern_id->pattern_id)->first() : null;

        $all_relations =  $pattern_id ? DB::table('similars')
            ->join('nisha', 'similars.nisha_id', '=', 'nisha.id')
            ->where('pattern_id', $pattern_id->pattern_id)->get() : [$good];
        $existing = [];

        foreach ($all_relations as $key => $value) {
            $existing["$value->id"] = $this->exist($value->id);
        }

        $sorted = [];
        foreach ($existing as $key => $value) {
            $sorted[$key] = $this->getMax($value);
        }

        arsort($sorted);

        return $sorted;
    }

    function getMax($array)
    {
        $max = 0;
        foreach ($array as $k => $v) {
            $max = $max < $v ? $v : $max;
        }
        return $max;
    }
}
