@extends('layouts.app')

@section('content')
    <div class="box-all">
        <div class="box-table">
            <div class="for-table1">
                <table class="table1">
                    <thead>
                    <tr>
                        <th class="id-th">id</th>
                        <th class="th">product name</th>
                        <th class="th">price</th>
                        <th class="interact-th">interact</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
{{--                        @if($product === $basket->product_id)--}}
                            <tr>
                                <td class="td">{{ $product->id }}</td>
                                <td class="td">{{ $product->name }}</td>
                                <td class="td">{{ $product->price }}</td>
                                <td>
                                    <button class="btn-del">X</button>
                                </td>
                            </tr>
{{--                        @endif--}}
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <button class="add-product">add</button>
            </div>
        </div>
        <div class="box-table-user">
            <div class="for-user">
                <div>
                    <button class="edit-order">edit</button>
                </div>
                <div class="user">
                    <p>Order name: {{ $order->name }}</p>
                    <p>Order status: {{ $order->status }}</p>
                </div>
            </div>
            <div class="for-table2">
                <div>
                    <button class="add-people">add</button>
                </div>
                <table class="table2">
                    <tbody>
                    @foreach($users as $user)
                        @dd($users)
                        <tr>
                            <td class="td">{{ $users->name  }} {{ $users->email }}</td>
                            <td>
                                <button class="btn-del">X</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
