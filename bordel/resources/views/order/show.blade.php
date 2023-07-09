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
                        <th class="table-header small-width interaction">действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($basket as $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td class="table-data">{{ $loop->index + 1 }}</td>
                            <td class="table-data">{{ $product->product_name }}</td>
                            <td class="table-data product-price"
                                data-product-id="{{ $product->id }}">{{ $product->price }}</td>
                            <td class="table-data grid">
                                <button class="btn-minus">&minus;</button>
                                <div class="product-amount">{{ $product->amount }}</div>
                                <button class="btn-plus">&plus;</button>
                            </td>
                            <td>
                                <button class="delete-button delete-product" data-product-id="{{ $product->id }}">X
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="table-data total-price">Итог: 0</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <button class="add-button" id="productModal">добавить</button>
                @if(!$paid)
                    <button class="add-button paid" id="productPaid" data-order-user-id="{{ $orderUserID->id }}" style="display: none">оплатить</button>
                @endif
            </div>
        </div>
        <div class="box-table-user">
            <div class="user-wrapper">
                <div>
                    <button class="order-edit-button" id="editModal">изменить</button>
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
                        @if(!$user->paid)
                            <tr data-people-id="{{ $user->id }}">
                                <td class="table-data">{{ $user->user->name  }} {{ $user->user->email }}</td>
                                <td class="table-data people-debt" style="display: none">Долг: {{ $user->debt }}</td>
                                <td colspan="1">
                                    <button class="delete-button delete-people" data-people-id="{{ $user->id }}">X
                                    </button>
                                </td>
                            </tr>
                        @endif
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
                <label>Имя заказа</label>
                <input id="orderNameInput" class="form-control mb-3" placeholder="Имя">
            </div>
            <div>
                <p class="h3 mb-3 order-status">Статус заказа: {{ $order->status }}</p>
                <button class="next-order" id="changeStatusOrdered">Изменить статус на заказано
                </button>
                <button class="next-order" id="changeStatusClosed" style="display:none;">Изменить статус на
                    доставлено
                </button>
            </div>
            <button class="add-button" id="editOrder">изменить</button>
        </div>
    </div>
    <div id="myModalPeople" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label>Пользователи</label>
                <select class="form-select mb-3" id="peopleSelect">
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}" data-user-id="{{ $user->id }}">
                            {{ $user->name }} {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="add-button" id="addPeople">добавить</button>
        </div>
    </div>
    <div id="myModalSure" class="my-modal-space">
        <div class="my-modal-content modal-sure">
            <h3>Вы уверены?</h3>
            <button class="yes-button" id="confirmButton">Да</button>
            <button class="no-button" id="cancelButton">Нет</button>
        </div>
    </div>
    <div id="addProductButton" data-add-product-url="{{ route('basket.store', $order->id) }}"></div>
    <div id="deleteProductButton" data-delete-product-url="{{ route('basket.destroy', $order->id) }}"></div>
    <div id="amountProductButtons" data-product-amount-url="{{ route('basket.update', $order->id) }}"></div>
    <div id="editOrderButton" data-edit-order-url="{{ route('order.update', $order->id) }}"></div>
    <div id="totalPrice" data-total-price-url="{{ route('debt.update', $order->id) }}"></div>
    <div id="addPeopleButton" data-add-people-url="{{ route('user.store', [$order->id, '__user_id__']) }}"></div>
    <div id="deletePeopleButton" data-delete-people-url="{{ route('user.destroy', $order->id) }}"></div>
    <div id="datas" data-order-name="{{ $order->name }}" data-order-status="{{ $order->status }}"
         data-is-owner="{{ $isOwner }}" data-user-id="{{ $currentUser->id }}"></div>
@endsection
