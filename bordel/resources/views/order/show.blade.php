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
                <button class="add-button" id="productModal">add</button>
            </div>
        </div>
        <div class="box-table-user">
            <div class="user-wrapper">
                <div>
                    <button class="order-edit-button" id="editModal">edit</button>
                </div>
                <div class="user-card">
                    <p class="order-info">Order name: {{ $order->name }}</p>
                    <p class="order-info">Order status: {{ $order->status }}</p>
                </div>
            </div>
            <div class="table-wrapper2">
                <div>
                    <button class="add-button" id="peopleModal">add</button>
                </div>
                <table class="data-table2">
                    <tbody>
                    @foreach($users as $user)
                        <tr data-people-id="{{ $user->id }}">
                            <td class="table-data">{{ $user->user->name  }} {{ $user->user->email }}</td>
                            <td>
                                <button class="delete-button" data-people-id="{{ $user->id }}">X</button>
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
            <button class="add-button" id="addProduct">Add</button>
        </div>
    </div>
    <div id="myModalEdit" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label>Order name</label>
                <input id="orderNameInput" class="form-control mb-3" placeholder="Enter order name">
            </div>
            <div>
                <label>Order status</label>
                <input id="orderStatusInput" class="form-control mb-3" placeholder="Enter order status">
            </div>
            <button class="add-button" id="editOrder">Edit</button>
        </div>
    </div>
    <div id="myModalPeople" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label>Users</label>
                <select class="form-select mb-3" id="peopleSelect">
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}" data-user-id="{{ $user->id }}">
                            {{ $user->name }} {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="add-button" id="addPeople">Add</button>
        </div>
    </div>
    <div id="addProductButton" data-add-product-url="{{ route('basket.store', $order->id) }}"></div>
    <div id="deleteProductButton" data-delete-product-url="{{ route('basket.destroy', $order->id) }}"></div>
    <div id="editOrderButton" data-edit-order-url="{{ route('order.update', $order->id) }}"></div>
    <div id="orderIDs" data-order-name="{{ $order->name }}" data-order-status="{{ $order->status }}"></div>
    <div id="addPeopleButton" data-add-people-url="{{ route('user.store', [$order->id, '__user_id__']) }}"></div>
    <div id="deletePeopleButton" data-delete-people-url="{{ route('user.destroy', $order->id) }}"></div>
    <script>
        $(document).ready(function () {
            var editOrderURL = $('#editOrderButton').data('edit-order-url');
            var currentName = $('#orderIDs').data('order-name');
            var currentStatus = $('#orderIDs').data('#order-status');

            $('#editOrder').click(function () {
                var newName = $('#orderNameInput').val();
                var newStatus = $('#orderStatusInput').val();
                var data = {
                    _method: 'PUT',
                };

                if (newName !== currentName) data.name = newName;
                if (newStatus !== currentStatus) data.status = newStatus;

                $.ajax({
                    url: editOrderURL,
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('.order-info').html('Order name: ' + response.order.name);
                        $('.order-info').html('Order status: ' + response.order.status);
                        $('#myModalEdit').hide();
                    }
                })
            });
        });
    </script>
@endsection
