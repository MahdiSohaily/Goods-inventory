<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodController extends Controller
{
    public function index()
    {
        $goods = DB::table('nisha')
            ->limit(10)
            ->orderBy('id', 'asc')
            ->get();

        $goods_count = DB::table('nisha')
            ->count();
        return Inertia::render('Goods/Show', ['goods' => $goods, 'count' => $goods_count]);
    }

    public function page(Request $request)
    {
        $page = $request->input('page');
        $pattern = $request->input('pattern');
        $limit = 10;
        $goods = null;
        $goods_count = DB::table('nisha')
            ->count();

        if ($pattern) {
            $goods_count = DB::table('nisha')
                ->where('partnumber', 'like', '%' . $pattern . '%')
                ->count();
            if ($goods_count > 10) {
                $goods = DB::table('nisha')
                    ->where('partnumber', 'like', '%' . $pattern . '%')
                    ->offset($limit * $page)
                    ->limit(10)
                    ->orderBy('id', 'asc')
                    ->get();
            } else {
                $goods = DB::table('nisha')
                    ->where('partnumber', 'like', '%' . $pattern . '%')
                    ->orderBy('id', 'asc')
                    ->get();
            }
        } else {
            $goods = DB::table('nisha')
                ->offset($limit * $page)
                ->limit(10)
                ->orderBy('id', 'asc')
                ->get();
        }

        return response()->json(['goods' => $goods, 'count' => $goods_count]);
    }

    public function search(Request $request)
    {
        $pattern = $request->input('pattern');
        $goods = null;

        if ($pattern) {
            $goods_count = DB::table('nisha')
                ->where('partnumber', 'like', '%' . $pattern . '%')
                ->count();
            if ($goods_count > 10) {
                $goods = DB::table('nisha')
                    ->where('partnumber', 'like', '%' . $pattern . '%')
                    ->limit(10)
                    ->orderBy('id', 'asc')
                    ->get();
            } else {
                $goods = DB::table('nisha')
                    ->where('partnumber', 'like', '%' . $pattern . '%')
                    ->orderBy('id', 'asc')
                    ->get();
            }
        } else {
            $goods = DB::table('nisha')
                ->limit(10)
                ->orderBy('id', 'asc')
                ->get();
        }

        return response()->json(['goods' => $goods, 'count' => $goods_count]);
    }
}
