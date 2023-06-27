@extends('layouts.app')

@section('content')
    <style>
        .box-all {
            display: flex;
            margin: 40px 50px 0 50px;
            height: 400px;
            border-radius: 7px;
            overflow: hidden;
        }

        .box-table {
            border-radius: 7px;
            background-color: deepskyblue;
            width: 75%;
            margin: 0 5px 0 15px;
            display: grid;
            position: relative;
        }

        .box-table-user {
            border-radius: 7px;
            margin: 0 15px 0 5px;
            width: 35%;
            display: grid;
            grid-template-rows: 35%;
        }

        .for-table1 {
            background-color: deepskyblue;
            height: 370px;
            border-radius: 7px;
            padding: 7px;
        }

        .for-user {
            background-color: orange;
            border-radius: 7px;
            display: grid;
            grid-template-rows: 20%;
            overflow: hidden;
            margin-bottom: 5px;
            position: relative;
        }

        .for-table2 {
            background-color: #9f57ef;
            margin-top: 5px;
            border-radius: 7px;
            position: relative;
        }

        .table1 {
            width: 100%;
            border-spacing: 15px;
            border-collapse: separate;
        }

        .user {
            background-color: orange;
            border-radius: 7px;
            line-height: 20px;
        }

        .table2 {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
            margin-top: 30px;
        }

        .th {
            background-color: mediumpurple;
            text-align: center;
            color: white;
            border-radius: 7px;
        }

        .td {
            text-align: center;
            background-color: #a1e7ff;
            border-radius: 7px;
        }

        .btn-del {
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            font-size: 15px;
            display: inline-block;
        }

        .id-th {
            background-color: mediumpurple;
            color: white;
            width: 20px;
            border-radius: 7px;
            padding: 5px;
        }

        .interact-th {
            background-color: mediumpurple;
            color: white;
            width: 20px;
            border-radius: 7px;
            padding: 5px;
            font-size: 10px;
        }

        p {
            margin: 15px 0 0 15px;
            font-size: 15px;
        }

        .add-product {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background-color: forestgreen;
            border: solid forestgreen;
            border-radius: 7px;
            width: 150px;
            height: 20px;
            text-align: center;
            line-height: 10px;
            color: white;
        }

        .edit-order {
            position: absolute;
            right: 10px;
            top: 10px;
            background-color: deepskyblue;
            border: solid deepskyblue;
            border-radius: 7px;
            width: 150px;
            height: 20px;
            text-align: center;
            line-height: 10px;
            color: white;
        }

        .add-people {
            position: absolute;
            right: 10px;
            top: 10px;
            background-color: forestgreen;
            border: solid forestgreen;
            border-radius: 7px;
            width: 150px;
            height: 20px;
            text-align: center;
            line-height: 10px;
            color: white;
        }
    </style>
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
