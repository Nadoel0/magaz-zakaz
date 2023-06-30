@extends('layouts.app')

@section('content')
    <style>
        .my-modal-space {
            display: none;
            background-color: rgb(0, 0, 0, 0.4);
            position: fixed;
            z-index: 1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .my-modal-content {
            background-color: forestgreen;
            margin: 15% auto;
            width: 50%;
            padding: 20px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            right: 10px;
            top: 5px;
            background-color: red;
            border: none;
            border-radius: 7px;
            width: 50px;
            height: 15px;
            text-align: center;
            line-height: 5px;
            color: white;
        }
    </style>
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
                <button id="product-open-modal" class="product-add-button">add</button>
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
    <div id="myModalSpace" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <h1>Модальное окно</h1>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.product-add-button').click(function () {
                $('#myModalSpace').show();
            });

            $('.close-modal').click(function () {
                $('#myModalSpace').hide();
            });

            $(window).click(function (event) {
                if(event.target == $('#myModalSpace')[0]) {
                    $('#myModalSpace').hide();
                }
            });
        });
    </script>
@endsection
