@extends('layouts.admin')

@section('content')

    <style>
         body {
            background-color: #bfbbb0 !important;
        }
        /* .products {
            display: grid !important;
            grid-template-columns:repeat(auto-fit, minmax(300px, auto)) !important;
            gap: 2rem;
        } */
    </style>

    @if (session('clearWish'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{session('clearWish')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <h4>Total Items - <b>{{Cart::instance('wishlist')->count()}}</b></h4>
    @if (Cart::instance('wishlist')->count() > 0)
        <div class="products row d-flex">
            @foreach (Cart::instance('wishlist')->content() as $item)
                <div class="card col-lg-3 col-md-5 col-sm-8 m-3 ">
                    <div class="card-body">
                        <div class="image mb-3">
                            <img src="{{asset('storage/'.$item->options['id'].'/'.$item->options['img'])}}" class="w-50" alt="">
                        </div>
                        <div class="info">
                            <h2>{{$item->name}}</h2>
                            <p>Price - {{$item->price}} $</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h3>There is no items in WishList.</h3>
    @endif

    <div class="mt-4">
        <button onclick="location='{{route('clear#wish')}}'" class="btn btn-danger">Clear Wishlist</button>
    </div>

    <button onclick="location='{{route('products#dashboard', 'date')}}'" class="mt-3 btn btn-secondary">Back</button>
@endsection
