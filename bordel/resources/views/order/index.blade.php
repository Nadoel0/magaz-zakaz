@extends('layouts.app')

@section('content')
    <div class="toggle-buttons">
        <button class="toggle-btn active" data-toggle="orders" data-target="opened-orders">Открытые заказы</button>
        <button class="toggle-btn" data-toggle="orders" data-target="closed-orders">Закрытые заказы</button>
    </div>
    <div class="orders-index">
        <div id="opened-orders" class="order-block">
            @foreach($orders as $order)
                @if($order->status !== 2)
                    <div class="order-cart" data-order-id="{{ $order->id }}" data-order-show-url="{{ route('order.show', $order->id) }}">
                        <h5>Заказ №{{ $order->id }}</h5>
                        <p>Имя заказа: {{ $order->name }}</p>
                        <p>Дата заказа: {{ $order->created_at->format('d/m/y H:i') }}</p>
                    </div>
                @endif
            @endforeach
        </div>

        <div id="closed-orders" class="order-block" style="display: none">
            @foreach($orders as $order)
                @if($order->status === 2)
                    <div class="order-cart" data-order-id="{{ $order->id }}" data-order-show-url="{{ route('order.show', $order->id) }}">
                        <h5>Заказ №{{ $order->id }}</h5>
                        <p>Имя заказа: {{ $order->name }}</p>
                        <p>Дата заказа: {{ $order->created_at }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="create-order-container">
        <button class="btn-create-order" data-target="opened=orders">Создать заказ</button>
    </div>
    <div id="myModalCreateOrder" class="my-modal-space">
        <div class="my-modal-content">
            <button class="close-modal">X</button>
            <label>Имя заказа</label>
            <input id="orderName" class="form-control" placeholder="Введите имя заказа">
            <p class="text-danger mb-3" id="nameError"></p>
            <label>Клиенты</label>
            <select multiple class="form-select" id="userSelect" name="user_id[]">
                @foreach($users as $user)
                    @if($user->name !== $owner->name)
                        <option value="{{ $user -> id }}">
                            {{ $user -> name }} {{ $user->email }}
                        </option>
                    @endif
                @endforeach
            </select>
            <p class="text-danger mb-3" id="userError"></p>
            <button id="createOrder" class="btn-create-order" data-order-show-url="{{ route('order.show', '__order_id__') }}">Создать заказ</button>
        </div>
    </div>
    <div id="createOrderButton" data-order-create-url="{{ route('order.store') }}" data-owner-id="{{ $owner->id }}"></div>
@endsection
