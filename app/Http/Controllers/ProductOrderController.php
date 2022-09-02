<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ProductOrder;
use Illuminate\Support\Facades\Notification;


class ProductOrderController extends Controller
{
    public function sendTestNotification() {

        $user = User::where('id',2)->first();

        $orderSuccessData = [
            'body' => 'You items are all available.',
            'orderSuccessText' => 'Your order is confirmed',
            'url' => url('/'),
            'thankyou' => 'Thank you for puchasing.',
        ];

        //first way to send noti
        // $user->notify(new ProductOrder($orderSuccessData));

        //sec way to send noti
        Notification::send($user, new ProductOrder($orderSuccessData));

        return 'done';
    }
}
