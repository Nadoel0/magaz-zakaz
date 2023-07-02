@extends('layouts.app')

@section('content')
    <style>
        .my-modal-space {
            display: none;
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            z-index: 1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .my-modal-content {
            background-color: #f8f8f8;
            margin: 14% auto;
            width: 50%;
            max-width: 500px;
            padding: 30px;
            position: relative;
            border-radius: 7px;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e74c3c;
            border: none;
            border-radius: 7px;
            width: 30px;
            height: 20px;
            text-align: center;
            line-height: 10px;
            color: white;
            font-size: 12px;
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
{{--                        @if($products->isNotEmpty())--}}
                            @foreach($basket as $product)
                            <tr>
                                <td class="table-data">{{ $product->product->id }}</td>
                                <td class="table-data">{{ $product->product->name }}</td>
                                <td class="table-data">{{ $product->product->price }}</td>
                                <td>
                                    <button class="delete-button">X</button>
                                </td>
                            </tr>
                            @endforeach
{{--                        @endif--}}
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
                    <p class="order-info">Order name: {{ $order->name }}</p>
                    <p class="order-info">Order status: {{ $order->status }}</p>
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
            <div>
                <label>Product</label>
                <select class="form-select mb-3" name="name" id="productSelect">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <input readonly class="form-control mb-3 modal-price-input" placeholder="Price">
            </div>
            <div>
                <label>Comment</label>
                <textarea class="form-control mb-3" placeholder="Comment"></textarea>
            </div>
            <div>
                <label>Price</label>
                <input class="form-control mb-3" placeholder="Price">
            </div>
            <button class="product-add-button" id="addProduct">Add</button>
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

        document.addEventListener('DOMContentLoaded', function () {
            var selectElement = document.querySelector('.form-select');
            var priceInput = document.querySelector('.modal-price-input');

            selectElement.addEventListener('change', function () {
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var price = selectedOption.getAttribute('data-price');
                priceInput.value = price;
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var addProductURL = "{{ route('basket.store', $order->id) }}";

        $(document).ready(function () {
            $('#addProduct').click(function () {
                var selectedProduct = $('#productSelect').val();
                var selectedPrice = $('#productSelect option:selected').data('price');
                var comment = $('.my-modal-content textarea').val();
                var price = $('.my-modal-content input[placeholder="Price"]').val();
                var inputPrice = comment ? price : selectedPrice;

                var data = {
                    order_id: {{ $order->id }},
                    user_od: {{ $user->user->id }},
                    product_id: selectedProduct,
                    price: inputPrice,
                    comment: comment
                };

                $.ajax({
                    url: addProductURL,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        alert('Product added');
                    }
                });
            });
        });
    </script>
@endsection
