<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Document;

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

    public function getCodeData($code, $customer, $search)
    {
        $good = DB::table('nisha')->where('id', $code)->first();

        $pattern_id = DB::table('similars')->where('nisha_id', $code)->first();

        $pattern = $pattern_id ? DB::table('patterns')->where('id', $pattern_id->pattern_id)->first() : null;

        $all_relations =  $pattern_id ? DB::table('similars')
            ->join('nisha', 'similars.nisha_id', '=', 'nisha.id')
            ->where('pattern_id', $pattern_id->pattern_id)->get() : [$good];

        $cars = $pattern_id ? DB::table('patterncars')
            ->join('cars', 'patterncars.car_id', '=', 'cars.id')
            ->where('patterncars.pattern_id', $pattern_id->pattern_id)->get() : null;

        $rates = DB::table('rates')
            ->orderBy('amount', 'asc')
            ->get();


        $partNumber = substr($good->partnumber, 0, 7);

        $prices = DB::table('prices')
            ->select('prices.*', 'customers.name', 'customers.last_name')
            ->join('customers', 'prices.customer_id', 'customers.id')
            ->where('prices.partnumber', 'like', "$partNumber%")
            ->orderBy('prices.created_at', 'desc')
            ->limit(4)
            ->get();

        $estelam = DB::table('estelam')
            ->select('estelam.*', 'seller.name')
            ->join('seller', 'estelam.seller', 'seller.id')
            ->where('estelam.partnumber', 'like', "$partNumber%")
            ->orderBy('estelam.time', 'desc')
            ->limit(4)
            ->get();
        $existing = [];
        foreach ($all_relations as $key => $value) {
            $existing["$value->id"] = $this->exist($value->id);
        }
        return  [
            'search' => $search, 'code' => $code, 'pattern' => $good->partnumber,
            'relations' => $all_relations, 'customer' => $customer, 'cars' => $cars,
            'rates' => $rates, 'prices' => $prices, 'name' => $pattern ? $pattern->name : 'Not in relation',
            'existing' => $existing, 'estelam' => $estelam,
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

        return [$brands, $amount];
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
}
