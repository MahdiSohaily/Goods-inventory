<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

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

    function clearNotification(Request $request)
    {
        $code = $request->input('code');
        $customer = $request->input('customer');
        $id = $request->input('id');

        if ($id) {
            DB::table('ask_price')
                ->where('id', $id)
                ->update(['status' => 'done']);
        }

        if ($customer) {
            DB::table('prices')->insert([
                'partnumber' => $code,
                'price' => 'نداریم',
                'customer_id' => $customer,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
