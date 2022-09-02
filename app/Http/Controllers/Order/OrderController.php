<?php

namespace App\Http\Controllers\Order;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function orderList() {

        $orders = Record::orderBy('id','desc')->get();

        return view('order', compact('orders'));
    }

    public function detail($id) {
        $order = Record::where('id', $id)->first();
        // return $order->record;
        return view('orderDetail', compact('order'));
    }
}
