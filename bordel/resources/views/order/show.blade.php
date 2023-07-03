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
                    @foreach($basket as $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td class="table-data">{{ $product->product->id }}</td>
                            <td class="table-data">{{ $product->product->name }}</td>
                            <td class="table-data">{{ $product->product->price }}</td>
                            <td>
                                <button class="delete-button" data-product-id="{{ $product->id }}">X</button>
                            </td>
                        </tr>
                    @endforeach
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
                    <button class="people-add-button" id="addUser">add</button>
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
    <div id="myModalProduct" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label>Product</label>
                <select class="form-select mb-3" id="productSelect">
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
    <div id="myModalPeople" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label>Users</label>
                <select class="form-select mb-3" id="peopleSelect">
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="people-add-button" id="addPeople">Add</button>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            function showModal(modalID) {
                $(modalID).show();
            }

            function hideModal() {
                $('.my-modal-space').hide();
            }

            $('.product-add-button').click(function () {
                showModal('#myModalProduct');
            });

            $('.people-add-button').click(function () {
                showModal('#myModalPeople');
            });

            $('.close-modal, .my-modal-space').click(function (event) {
                if (event.target === this) {
                    hideModal();
                }
            })
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

        $(document).ready(function () {
            var addProductURL = '{{ route('basket.store', $order->id) }}';
            var deleteProductURL = '{{ route('basket.destroy', $order->id) }}';

            $('#addProduct').click(function () {
                var selectedProduct = $('#productSelect').val();
                var selectedPrice = $('#productSelect option:selected').data('price');
                var comment = $('.my-modal-content textarea').val();
                var price = $('.my-modal-content input[placeholder="Price"]').val();
                var inputPrice = comment ? price : selectedPrice;
                var data = {
                    _token: '{{ csrf_token() }}',
                    product_id: selectedProduct,
                    comment: comment,
                    price: inputPrice,
                };

                $.ajax({
                    url: addProductURL,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        var addedProducts = `<tr>
                                <td class="table-data">${response.product.id}</td>
                                <td class="table-data">${response.product.name}</td>
                                <td class="table-data">${response.product.price}</td>
                                <td>
                                    <button class="delete-button">X</button>
                                </td>
                            </tr>`;
                        $('.data-table1 tbody').append(addedProducts);
                        $('#productSelect').val('');
                        $('.my-modal-content textarea').val('');
                        $('.my-modal-content input[placeholder="Price"]').val('');
                        $('#myModalProduct').hide();
                    }
                });
            });

            function deleteProduct(productID) {
                var data = {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}',
                    product_id: productID,
                };
                console.log(data)
                $.ajax({
                    url: deleteProductURL,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        $('.data-table1 tbody tr[data-product-id="' + productID + '"]').remove();
                    }
                });
            }

            $(document).on('click', '.delete-button', function () {
                var productID = $(this).closest('tr').data('product-id');
                deleteProduct(productID);
            });
        });
    </script>
@endsection
