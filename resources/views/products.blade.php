@extends('layouts.admin')

@section('content')

    <style>
         body {
            background-color: #bfbbb0 !important;
        }
        .products {
            display: grid !important;
            grid-template-columns:repeat(auto-fit, minmax(300px, auto)) !important;
            gap: 2rem;
        }


    </style>



    {{-- <div class="dropdown mb-4">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Sort By
        </button>
        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="{{route('products#dashboard', 'date')}}">Sort by newness</a>
          <a class="dropdown-item" href="{{route('products#dashboard', 'asec')}}">Sort by price : low to high</a>
          <a class="dropdown-item" href="{{route('products#dashboard', 'desc')}}">Sort by price : high to low</a>
        </div>
      </div> --}}

      <div class="row">
        <div class="col-4 ms-5">
            <select name="sorting" id="sortingOption" class="form-control">
                <option value="default" disabled selected>Sort by</option>
                <option value="asc">Sort by price : low to high</option>
                <option value="desc">Sort by price : high to low</option>
            </select>
        </div>
      </div>

    @if(session('addCartSuccess'))
        <div class="mt-3 alert alert-warning alert-dismissible fade show" role="alert">
            {{session('addCartSuccess')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('ordered'))
        <div class="mt-3 alert alert-warning alert-dismissible fade show" role="alert">
            {{session('ordered')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('wishAdd'))
        <div class="mt-3 alert alert-warning alert-dismissible fade show" role="alert">
            {{session('wishAdd')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="items d-flex products mt-3" id="items">

        @foreach ($products as $product)
        <div class="card  m-3 ">
            <div class="card-body">
                <div class="image">
                    <img src="{{$product->photo['url']}}" class="w-50" alt="">
                </div>
                {{-- {{dd(gettype($product->photo['file_name']))}} --}}
                <div class="info">
                    <h2>{{$product->name}}</h2>
                    <p>Price - {{$product->price}} $</p>
                </div>
            <a href="{{route('product#store', [$product->id, $product->name, $product->price,$product->photo['id'], $product->photo['file_name']])}}">
                <button  class="btn btn-success">Add to Cart</button>
            </a>
            <a href="{{route('product#wishList', [$product->id, $product->name, $product->price, $product->photo['id'], $product->photo['file_name']])}}">
                <button class="btn btn-warning  ">WishList</button>
            </a>
            </div>
        </div>
        @endforeach
    </div>
@endsection

{{-- --------ajax test------- --}}

@section('scriptTest')
    <script>

        $(document).ready(function() {
            $('#sortingOption').change(function() {
                $sortValue = $('#sortingOption').val();

                if($sortValue == 'asc') {
                    $.ajax({
                        method : 'get',
                        url : 'http://cart.test/ajax/product/list',
                        dataType : 'json',
                        data : {'status' : 'asc'},
                        success : function(res) {
                            $products = '';
                            for($i=0; $i<res.length; $i++) {
                                $products += `
                                <div class="card  m-3 ">
                                    <div class="card-body">
                                        <div class="image">
                                            <img src="${res[$i].photo.url}" class="w-50" alt="">
                                        </div>
                                        {{-- {{dd(gettype($product->photo['file_name']))}} --}}
                                        <div class="info">
                                            <h2>${res[$i].name}</h2>
                                            <p>Price - ${res[$i].price} $</p>
                                        </div>
                                    <a href="{{route('product#store', [$product->id, $product->name, $product->price,$product->photo['id'], $product->photo['file_name']])}}">
                                        <button  class="btn btn-success">Add to Cart</button>
                                    </a>
                                    <a href="{{route('product#wishList', [$product->id, $product->name, $product->price, $product->photo['id'], $product->photo['file_name']])}}">
                                        <button class="btn btn-warning  ">WishList</button>
                                    </a>
                                    </div>
                                </div>
                                `;

                            }

                            $('#items').html($products);

                        }
                    })
                } else {
                    $.ajax({
                        method : 'get',
                        url : 'http://cart.test/ajax/product/list',
                        dataType : 'json',
                        data : {'status' : 'desc'},
                        success : function(res) {
                            $products = '';
                            for($i=0; $i<res.length; $i++) {
                                $products += `
                                <div class="card  m-3 ">
                                    <div class="card-body">
                                        <div class="image">
                                            <img src="${res[$i].photo.url}" class="w-50" alt="">
                                        </div>
                                        {{-- {{dd(gettype($product->photo['file_name']))}} --}}
                                        <div class="info">
                                            <h2>${res[$i].name}</h2>
                                            <p>Price - ${res[$i].price} $</p>
                                        </div>
                                    <a href="{{route('product#store', [$product->id, $product->name, $product->price,$product->photo['id'], $product->photo['file_name']])}}">
                                        <button  class="btn btn-success">Add to Cart</button>
                                    </a>
                                    <a href="{{route('product#wishList', [$product->id, $product->name, $product->price, $product->photo['id'], $product->photo['file_name']])}}">
                                        <button class="btn btn-warning  ">WishList</button>
                                    </a>
                                    </div>
                                </div>
                                `;

                            }

                            $('#items').html($products);

                        }
                    })
                }

            })
        });

    </script>
@endsection
