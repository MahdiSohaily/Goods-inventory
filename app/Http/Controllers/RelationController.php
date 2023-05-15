<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $nisha = DB::table('nisha')
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

        $final_result = [];

        foreach ($nisha as $key => $value) {
            $id = $value->id;

            $get_nisha = null;

            foreach ($similar_ids as $item) {
                if ($item['nisha_id'] == $id) {
                    $get_nisha = $item['pattern_id'];
                }
            }
            array_push($final_result, ['id' => $id, 'partNumber' => $value->partnumber, 'pattern' => $get_nisha]);
        }

        return $final_result;
    }

    public function store(Request $request)
    {
        // START Validation the request
        Validator::make($request->all(), [
            'values' => 'required',
            'body' => 'required',
        ], [
            'required' => "The selected items section can't be empty.",
        ])->validate();
        // END validation



        $selected_index = [];
        $values = $request->input('values');
        try {
            foreach ($values as $key => $value) {
                array_push($selected_index, $value->id);
            }


            DB::transaction(function ($request, $selected_index) {

                // Extract individual variables from the request body
                $selected_index = array_unique($selected_index);
                $serial = $request->input('pattern');
                $name = $request->input('name');
                $car_id = $request->input('values');
                $status_id = $request->input('status_id');

                // create the pattern record
                $pattern = new Pattern();
                $pattern->name = $name;
                $pattern->serial = $serial;
                $pattern->car_id = $car_id;
                $pattern->status_id = $status_id;
                $pattern->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
        }


        return redirect('/posts');
    }
}
