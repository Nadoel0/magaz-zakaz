@extends('layouts.app')

@section('content')
    <div class="toggle-buttons">
        <button class="toggle-btn" data-toggle="orders" data-target="opened-orders">Открытые заказы</button>
        <button class="toggle-btn" data-toggle="orders" data-target="closed-orders">Закрытые заказы</button>
    </div>
    <div class="orders-index">
        <div id="opened-orders" class="order-block">
            @foreach($orders as $order)
                @if($order->status !== 3)
                    <div class="order-cart" data-order-id="{{ $order->id }}">
                        <h5>Заказ №{{ $order->id }}</h5>
                        <p>Имя заказа: {{ $order->name }}</p>
                        <p>Дата заказа: {{ $order->created_at }}</p>
                    </div>
                @endif
            @endforeach
        </div>

        <div id="closed-orders" class="order-block" style="display: none">
            @foreach($orders as $order)
                @if($order->status === 3)
                    <div class="order-cart" data-order-id="{{ $order->id }}">
                        <h5>Заказ №{{ $order->id }}</h5>
                        <p>Имя заказа: {{ $order->name }}</p>
                        <p>Дата заказа: {{ $order->created_at }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.order-cart').click(function () {
                var orderId = $(this).data('order-id');
                var url = "{{ route('order.show', ':orderId') }}";
                url = url.replace(':orderId', orderId);
                window.location.href = url;
            });
        });
    </script>
@endsection
