<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Order Detail</title>
</head>
<style>
    body {
            background-color: #bfbbb0 !important;
            /* color : #bb964d; */
        }

    .card-header {
        background-color: #313438;
        color: #f5a60a;
    }

    .card-body {
        background-color: #82807d;
    }

    table {
        background-color: #b2dbbd;
    }

    .card-footer {
        background-color: #b2dbbd;

    }
</style>
<body>
    <div class="container mt-5">
        <div class="card w-75 m-auto mb-4">
            <div class="card-header">
                <div class="mb-4">
                    <p onclick="location='{{route('order#list')}}'"><i class="fa-solid fa-arrow-left-long"></i></p>
                    <h3 class="text-center mb-1">
                        Customer Order Detail
                        {{-- @foreach (json_decode($order->record,true) as $key => $value)
                            {{$value['name']}}&nbsp;({{$value['qty']}}),&nbsp;

                            <img src="{{asset('storage/'.$value['options']['id'].'/'.$value['options']['img'])}}" alt="">
                        @endforeach --}}
                    </h3>
                </div>
            </div>
            <div class="card-body">
                {{-- -----customer info-----  --}}
                <div class="row mt-4">
                    <div class="col-8 offset-2">
                        <div class="row ">
                            <div class="col-3 ">
                                <p class="mt-3">Customer Name </p class="mt-3">
                            </div>
                            <div class="col-9 ">
                                <p class="fs-3"><b>: {{$order->name}}</b></p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-3 ">
                                <p class="mt-3">Email </p class="mt-3">
                            </div>
                            <div class="col-9 ">
                                <p class="fs-5">: {{$order->email}}</p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-3 ">
                                <p class="mt-3">Address </p class="mt-3">
                            </div>
                            <div class="col-9 ">
                                <p class="fs-5">: {{$order->address}}</p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-3 ">
                                <p class="mt-3">Phone </p class="mt-3">
                            </div>
                            <div class="col-9 ">
                                <p class="fs-5">: {{$order->phone}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- -------product info---------  --}}
                <div class="row my-5">
                    <h5>Ordered Products List</h5>
                </div>
                <div class="row px-xl-5">
                    <div class="col-lg-12 col-md-7 table-responsive mb-5 m-auto">
                        <table class="table table-light table-borderless table-striped table-hover table-dark text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Sub_Total</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach (json_decode($order->record,true) as $key => $value)
                                        <tr>
                                            <td class="align-middle"><img src="{{asset('storage/'.$value['options']['id'].'/'.$value['options']['img'])}}" alt="" style="width: 100px;"></td>
                                            <td class="align-middle">{{$value['name']}}</td>
                                            <td class="align-middle">{{$value['price']}} $</td>
                                            <td class="align-middle">{{$value['qty']}} </td>
                                            <td class="align-middle">{{$value['subtotal']}} $</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="fs-5 text-center" colspan='4'>Total Price</td>
                                        <td>{{$order->total_price}} $</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-center mt-1"><i class="fa-solid fa-face-laugh-beam text-success me-2"></i>Thank you very much. Have a great day<i class="fa-solid fa-face-laugh-beam text-success ms-2"></i></p>
            </div>
        </div>
    </div>
</body>
</html>
