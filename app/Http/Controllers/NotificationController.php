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
        $notifications = DB::table('ask_price')
            ->join('users', 'users.id', '=', 'ask_price.user_id')
            ->join('customers', 'customers.id', '=', 'ask_price.customer_id')
            ->select('ask_price.*', 'users.id AS user_id', 'customers.id AS customer_id', 'customers.name AS customer_name', 'users.name AS user_name')
            ->where('status', '=', 'pending')->get();

        return Inertia::render('Notifications/Show', ['notifications' => $notifications]);
    }
}
