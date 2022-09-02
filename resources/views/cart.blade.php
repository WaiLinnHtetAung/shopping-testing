@extends('layouts.admin')

@section('content')

    <style>

        body {
            background-color: #bfbbb0 !important;
        }
        .cart_products {
            display: grid !important;
            grid-template-columns:repeat(auto-fit, minmax(300px, auto)) !important;
            gap: 2rem;
        }
    </style>

    @if (session('clearCart'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{session('clearCart')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row px-xl-5">
        <div class="col-lg-8 mb-3">
            <button onclick="location='{{route('products#dashboard', 'date')}}'" class="btn btn-secondary mb-3 "><i class="fa-solid fa-arrow-left me-3"></i>&nbsp;Back</button>&nbsp;&nbsp;
            <button onclick="location='{{route('cart#clear')}}'" class="btn btn-danger mb-3"><i class="fa-solid fa-trash-arrow-up"></i>&nbsp;Clear Cart</button>
        </div>
    </div>

    @if (Cart::count() > 0)
        <div class="row px-xl-5">
            <div class="col-lg-8 mb-2">
                <h4>Total Items - <b>{{Cart::count()}}</b></h4>
            </div>

        </div>
        {{-- <div class="cart_products">
            @foreach (Cart::content() as $item)
                <div class="card m-3 position-relative">
                <span onclick="location='{{route('remove#item', $item->rowId)}}'" class="position-absolute top-0 end-0 align-self-end me-2">
                    <i class="fa-solid fa-xmark fa-2x p-2"></i>
                </span>
                    <div class="card-body">
                        <div class="image mb-3">
                            <img src="{{asset('storage/'.$item->options['id'].'/'.$item->options['img'])}}" class="w-50" alt="">

                        </div>
                        <div class="info">
                            <h2>{{$item->name}}</h2>
                            <p>Price - {{$item->price}} $</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 ms-2 mx-3 ">
                            <a href="{{route('item#increase', $item->rowId)}}" class="me-3"><i class="fa-solid fa-plus fa-2x p-2 bg-dark shadow"></i></a>
                            <a href="{{route('item#decrease', $item->rowId)}}"><i class="fa-solid fa-minus fa-2x p-2 bg-dark shadow"></i></a>
                        </div>

                        <div class="col-5 ms-2">
                            <p>Quantity - {{$item->qty}}</p>
                            <p>Suttotal - {{$item->subtotal}} $</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                            @foreach (Cart::content() as $item)
                                <tr>
                                    <td class="align-middle"><img src="{{asset('storage/'.$item->options['id'].'/'.$item->options['img'])}}" alt="" style="width: 50px;"> {{$item->name}}</td>
                                    <td class="align-middle">{{$item->price}} $</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button onclick="location='{{route('item#decrease', $item->rowId)}}'" class="btn btn-sm btn-primary btn-minus" >
                                                <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{$item->qty}}">
                                            <div class="input-group-btn">
                                                <button onclick="location='{{route('item#increase', $item->rowId)}}'" class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{$item->subtotal}} $</td>
                                    <td class="align-middle"><button onclick="location='{{route('remove#item', $item->rowId)}}'" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Cart Summary</span></h5>
                <div class=" p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>{{Cart::subtotal()}} $</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Tax</h6>
                            <h6 class="font-weight-medium">{{Cart::tax()}} $</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>{{Cart::total()}} $</h5>
                        </div>
                        {{-- <button onclick="location=''" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- ==========User Data Form============  --}}

        <h3 class="text-center mt-3">Enter your Information</h3>
        <form action="{{route('order')}}" method="post" class="mb-3 m-auto w-50 pb-4">
            @csrf
            <label for="">UserName</label>
            <input type="text" name="name" required class="form-control mb-3 shadow-sm">
            <label for="">Email Address</label>
            <input required type="email" name="email" class="form-control mb-3 shadow-sm">
            <label for="">Address</label>
            <textarea required name="address" id="" cols="30" rows="10" class="form-control shadow-sm"></textarea>
            <label for="">Phone</label>
            <input required type="number" name="phone" class="form-control mb-3 shadow-sm">

            {{-- noti message  --}}
            <input type="hidden" name="notiMsg" value="New order is arrived! Check now.">

            <button onclick="location=''" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
        </form>
    @else
        <h3 class="text-center mt-3">There is no items.</h3>
        <div class="text-center my-5">
            <button onclick="location='{{route('products#dashboard')}}'" class="btn btn-success rounded p-2 px-3">Go to add items</button>
        </div>
    @endif





@endsection
