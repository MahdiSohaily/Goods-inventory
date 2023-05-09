<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        if ($mode) {
            $sql="SELECT * FROM nisha WHERE partnumber LIKE '".$key."%'";
        } else {
            $sql="SELECT * FROM nisha WHERE partnumber LIKE '".$key."%'";
        }
        return response()->json([$request->all()]);
    }
}
