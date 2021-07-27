@extends('frontend.layouts.master')

@section('title')
    <title> E-Shopper</title>
@endsection

@section('css')
    <link href="{{asset('home-frontend/home.css')}}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{asset('home-frontend/home.js')}}"></script>
@endsection

@section('content')

    <section>
        <div class="container">
            <div class="row">
                @include('frontend.components.sidebar')
                <div class="col-sm-9 padding-right">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach($carts as $cartItem)
                            @php
                                $total += ($cartItem['price'] * $cartItem['quantity']);
                            @endphp
                            <tr>
                                <th scope="row"><img src="{{$cartItem['image']}}" style="width: 130px;height: 130px">
                                </th>
                                <th scope="row">{{$cartItem['name']}}</th>
                                <th scope="row">{{number_format($cartItem['price'])}}</th>
                                <th scope="row"><input type="number" value="{{$cartItem['quantity']}}" min="1"
                                                       style="width: 50px"></th>
                                <th scope="row">{{number_format($cartItem['price'] * $cartItem['quantity'])}} VNĐ</th>
                                <td>
                                    <a href="#" class="btn btn-default">Cập nhật</a>
                                    <a href="#" class="btn btn-danger">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <h1>Tổng tiền: {{number_format($total)}} VNĐ</h1>
                </div>
            </div>
        </div>
    </section>

@endsection





