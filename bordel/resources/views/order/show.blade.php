@extends('layouts.app')

@section('content')
    <div class="container-box">
        <div class="table-container">
            <div class="table-wrapper1">
                <table class="data-table1">
                    <thead>
                    <tr>
                        <th class="id-header">id</th>
                        <th class="table-header">product name</th>
                        <th class="table-header">price</th>
                        <th class="interaction-header">interact</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                            <tr>
                                <td class="table-data">{{ $product->id }}</td>
                                <td class="table-data">{{ $product->name }}</td>
                                <td class="table-data">{{ $product->price }}</td>
                                <td>
                                    <button class="delete-button">X</button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div>
                <button class="product-add-button">add</button>
            </div>
        </div>
        <div class="box-table-user">
            <div class="user-wrapper">
                <div>
                    <button class="order-edit-button">edit</button>
                </div>
                <div class="user-card">
                    <p>Order name: {{ $order->name }}</p>
                    <p>Order status: {{ $order->status }}</p>
                </div>
            </div>
            <div class="table-wrapper2">
                <div>
                    <button class="people-add-button">add</button>
                </div>
                <table class="data-table2">
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="table-data">{{ $user->user->name  }} {{ $user->user->email }}</td>
                            <td>
                                <button class="delete-button">X</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
