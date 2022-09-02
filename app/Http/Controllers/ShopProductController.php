<?php

namespace App\Http\Controllers;
use Cart;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ShopProductController extends Controller
{
    public function products() {

        $products = Product::get();
        return view('products', compact('products'));

    }

    public function store($id, $name, $price,$fileId, $file) {

        Cart::add($id, $name, 1, $price, ['id' => $fileId ,'img'=>$file]);

        return redirect()->back()->with(['addCartSuccess' => 'Item is added to cart successfully']);

    }

    public function wishList($id, $name, $price, $fileId, $file) {
        Cart::instance('wishlist')->add($id, $name, 1, $price, ['id' => $fileId ,'img'=>$file]);
        return redirect()->back()->with(['wishAdd' => 'Item is added to wish list successfully']);

    }
}
