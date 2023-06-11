<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $hasNotification = DB::table('ask_price')->where('status', '=', 'pending')->get();

        return count($hasNotification);
    }

    public function getNotification()
    {
        return Inertia::render('Price/Show');
    }
}
