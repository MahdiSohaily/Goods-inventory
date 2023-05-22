<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceController extends Controller
{
    public function index()
    {
        return Inertia::render('Price/Show');
    }

    public function load(Request $request)
    {
        Validator::make($request->all(), [
            'customer' => 'required',
            'code' => 'required',
        ], [
            'required' => "The :attribute field can't be empty.",
        ])->validate();

    }
}