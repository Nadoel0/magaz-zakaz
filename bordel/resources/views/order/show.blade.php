@extends('layouts.app')

@section('content')
    <div class="container-box">
        <div class="table-container">
            <div class="table-wrapper1">
                <table class="data-table1">
                    <thead>
                    <tr>
                        <th class="table-header small-width">id</th>
                        <th class="table-header">продукт</th>
                        <th class="table-header">цена</th>
                        <th class="table-header small-width">количество</th>
                        <th class="table-header small-width">действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($basket as $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td class="table-data">{{ $loop->index + 1 }}</td>
                            <td class="table-data">{{ $product->product_name }}</td>
                            <td class="table-data product-price" data-product-id="{{ $product->id }}">{{ $product->price }}</td>
                            <td class="table-data grid">
                                <button class="btn-minus">&minus;</button>
                                <div class="product-amount">{{ $product->amount }}</div>
                                <button class="btn-plus">&plus;</button>
                            </td>
                            <td>
                                <button class="delete-button delete-product" data-product-id="{{ $product->id }}">X</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="table-data total-amount">
                            <strong>Итог:</strong>
                            <span>0</span>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <button class="add-button" id="productModal">добавить</button>
            </div>
        </div>
        <div class="box-table-user">
            <div class="user-wrapper">
                <div>
                    @if($order->status === 3)
                        <button class="end-button" id="closeOrder">закрыть заказ</button>
                    @else
                        <button class="order-edit-button" id="editModal">изменить</button>
                    @endif
                </div>
                <div class="user-card">
                    <p class="order-info order-name">Имя заказа: {{ $order->name }}</p>
                    <p class="order-info order-status">Статус заказа: {{ $order->status }}</p>
                </div>
            </div>
            <div class="table-wrapper2">
                <div>
                    <button class="add-button" id="peopleModal">добавить</button>
                </div>
                <table class="data-table2">
                    <tbody>
                    @foreach($users as $user)
                        <tr data-people-id="{{ $user->id }}">
                            <td class="table-data">{{ $user->user->name  }} {{ $user->user->email }}</td>
                            <td>
                                <button class="delete-button delete-people" data-people-id="{{ $user->id }}">X</button>
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
            <label class="mb-3">Добавление продукта</label>
            <input class="form-control mb-3" id="productNameInput" placeholder="Продукт">
            <input class="form-control mb-3" id="productPriceInput" placeholder="Цена">
            <input class="form-control mb-3" id="productAmountInput" placeholder="Кол-во">
            <textarea class="form-control mb-3" id="productCommentInput" placeholder="Комменарий к заказу"></textarea>
            <button class="add-button" id="addProduct">добавить</button>
        </div>
    </div>
    <div id="myModalEdit" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label>Order name</label>
                <input id="orderNameInput" class="form-control mb-3" placeholder="Name">
            </div>
            <div>
                <p class="h3 mb-3">Статус заказа: {{ $order->status }}</p>
                @if($order->status === 1)
                    <button class="next-order" id="changeStatusButton" data-status="ordered">Изменить статус на
                        заказано
                    </button>
                @elseif($order->status === 2)
                    <button class="next-order" id="changeStatusButton" data-status="delivered">Изменить статус на
                        доставлено
                    </button>
                @endif
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
    <div id="myModalSure" class="my-modal-space">
        <div class="my-modal-content">
            <h3>Are you sure?</h3>
            <button class="yes-button" id="confirmButton">Yes</button>
            <button class="no-button" id="cancelButton">No</button>
        </div>
    </div>
    <div id="addProductButton" data-add-product-url="{{ route('basket.store', $order->id) }}"></div>
    <div id="deleteProductButton" data-delete-product-url="{{ route('basket.destroy', $order->id) }}"></div>
    <div id="amountProductButtons" data-product-amount-url="{{ route('basket.update', $order->id) }}"></div>
    <div id="editOrderButton" data-edit-order-url="{{ route('order.update', $order->id) }}"></div>
    <div id="orderIDs" data-order-name="{{ $order->name }}" data-order-status="{{ $order->status }}"></div>
    <div id="addPeopleButton" data-add-people-url="{{ route('user.store', [$order->id, '__user_id__']) }}"></div>
    <div id="deletePeopleButton" data-delete-people-url="{{ route('user.destroy', $order->id) }}"></div>
    <div id="isOwner" data-is-owner="{{ $isOwner }}"></div>
    <div id="debtButton" data-debt-url="{{ route('order.debt', $order->id) }}"></div>
@endsection
