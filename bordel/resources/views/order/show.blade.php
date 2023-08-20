@extends('layouts.app')

@section('content')
    <div>
        <h3>Имя заказа: {{ $order->name }}</h3>
        <h6>Дата заказа: {{ $order->created_at->format('d/m/y H:i') }}</h6>
    </div>
    <div class="container-box">
        <div class="table-container">
            <div class="table-wrapper1">
                <table class="data-table1">
                    <thead>
                    <tr>
                        <th class="table-header">продукт</th>
                        <th class="table-header">цена</th>
                        <th class="table-header small-width">количество</th>
                        <th class="table-header small-width interaction">действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($basket as $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td class="table-data product-name">{{ $product->product_name }}</td>
                            <td class="table-data product-price"
                                data-product-id="{{ $product->id }}">{{ $product->price }}</td>
                            <td class="table-data grid">
                                <button class="btn-minus">&minus;</button>
                                <div class="product-amount">{{ $product->amount }}</div>
                                <button class="btn-plus">&plus;</button>
                            </td>
                            <td>
                                <button class="product-edit" data-product-id="{{ $product->id }}">изменить</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="table-data total-price">Итог: 0</td>
                    </tr>
                    </tfoot>
                </table>
                <div class="product-action-btn">
                    <button class="btn-add" id="productModal">добавить</button>
                </div>
                @if(!$paid)
                    @if (!$isOwner)
                        <div class="product-action-btn">
                            <button class="btn-add" id="productPaid" data-order-user-id="{{ $orderUserID->id }}"
                                    style="display: none">оплачено
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="box-table-user">
            <div class="user-wrapper">
                <div class="order-status-cart">
                    <p class="table-data order-status">Статус заказа: {{ $order->status }}</p>
                </div>
                <div class="order-next-cart">
                    <button class="next-order" id="changeStatusClosed">Изменить на доставлено</button>
                </div>
            </div>
            <div class="table-wrapper2">
                <table class="data-table2">
                    <tbody>
                    @foreach($users as $user)
                        @if(!$user->paid)
                            @if($user->user->name !== $currentUser->name)
                                <tr data-people-id="{{ $user->id }}">
                                    <td class="table-data">{{ $user->user->name  }} {{ $user->user->email }}</td>
                                    <td class="table-data people-debt" style="display: none">
                                        Долг: {{ $user->debt }}</td>
                                    <td colspan="1">
                                        <button class="delete-button delete-people" data-people-id="{{ $user->id }}">X
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="product-action-btn">
                    <button class="btn-add" id="peopleModal">добавить</button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <button class="btn-back" data-back="{{ route('order.index') }}">Назад к заказам</button>
    </div>

    <div id="myModalProduct" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal mb-3">X</button>
            <label class="table-data label mb-3">Добавление продукта</label>
            <input class="form-control mb-3" id="productNameInput" placeholder="Продукт">
            <input class="form-control mb-3" id="productPriceInput" placeholder="Цена">
            <input class="form-control mb-3" id="productAmountInput" placeholder="Кол-во">
            <textarea class="form-control mb-3" id="productCommentInput" placeholder="Комменарий к заказу"></textarea>
            <div class="product-action-btn">
                <button class="btn-add" id="addProduct">добавить</button>
            </div>
        </div>
    </div>

    <div id="myModalProductEdit" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <label class="table-data label mb-3">Редактирование продукта</label>
            <input type="hidden" id="productID">
            <input class="form-control mb-3" id="editProductNameInput" placeholder="Продукт">
            <input class="form-control mb-3" id="editProductPriceInput" placeholder="Цена">
            <input class="form-control mb-3" id="editProductAmountInput" placeholder="Кол-во">
            <textarea class="form-control mb-3" id="editProductCommentInput"
                      placeholder="Комментарий к заказу"></textarea>
            <div class="product-action-btn">
                <button class="btn-delete" id="deleteProduct">удалить</button>
                <button class="btn-edit" id="editProduct">изменить</button>
            </div>
        </div>
    </div>

    <div id="myModalPeople" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <div>
                <label class="table-data label mb-3">Пользователи</label>
                <select class="form-select mb-3" id="peopleSelect">
                    @foreach($usersNotInOrder as $user)
                        <option value="{{ $user->id }}" data-user-id="{{ $user->id }}">
                            {{ $user->name }} {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="product-action-btn">
                <button class="btn-add" id="addPeople">добавить</button>
            </div>
        </div>
    </div>

    <div id="myModalSure" class="my-modal-space">
        <div class="my-modal-content modal-sure">
            <h3>Вы уверены?</h3>
            <div class="product-action-btn">
                <button class="next-status-button" id="confirmButton">Да</button>
                <button class="next-status-button" id="cancelButton">Нет</button>
            </div>
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
