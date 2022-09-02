<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\User;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Events\RealTimeMessage;
use App\Events\OrderNotification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RealTimeNotification;

class CartItemController extends Controller
{
    public function items() {
        return view('cart');
    }

    public function clear() {
        Cart::destroy();

        return redirect()->back()->with(['clearCart' => 'Cart is cleared successfully']);
    }

    public function wish() {
        return view('wishList');
    }

    public function increase($rowId) {
        $product = Cart::get($rowId);
        $qty = $product->qty+1;
        Cart::update($rowId, $qty);
        // event(new RealTimeMessage('Hello World this is from cart items order'));

        return redirect()->back();
    }

    public function decrease($rowId) {
        $product = Cart::get($rowId);
        $qty = $product->qty-1
        ;
        Cart::update($rowId, $qty);
        return redirect()->back();

    }

    public function remove($id) {
        Cart::remove($id);

        return redirect()->back();
    }

    public function clearWish() {
        Cart::instance('wishlist')->destroy();

        return redirect()->back()->with(['clearWish' => 'Wish List is cleared successfully']);
    }

    public function checkout() {
        return view('checkout');
    }

    public function order(Request $request) {

        $cart = Cart::content();

        // $ans = json_encode($cart);

        $total_price = $this->changeInt(Cart::total());
        $total_qty = $this->changeInt(Cart::count());
        $total_tax = $this->changeInt(Cart::tax());

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'record' => $cart,
            'total_price' => $total_price,
            'total_qty' => $total_qty,
            'total_tax' => $total_tax,
            'status' => 'pending',
        ];

        $userInfo = Record::create($data);

        $admins = User::whereHas('roles', function($query) {
            $query->where('id', 1);
        })->get();

        foreach($admins as $admin) {
            $admin->notify(new RealTimeNotification('New order is arrived! Check now', $userInfo));
        }

        // ------order succes noti------
        // OrderNotification::dispatch('New order arrived! Check now!');
        // event(new OrderNotification($request->notiMsg));


        Cart::destroy();
        return redirect()->route('products#dashboard')->with(['ordered' => 'Order Success']);
    }




    private function changeInt($strr) {
        $num = explode(',',$strr);
        $ans = implode('',$num);

        return (int)$ans;
    }
}
