<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function productList(Request $request) {

        if($request->status == 'asc') {
            $data = Product::orderBy('price', 'asc')->get();
        } else {
            $data = Product::orderBy('price', 'desc')->get();
        }

        return $data;
    }
}
