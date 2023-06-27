@extends('layouts.app')

@section('content')
    <div>
        @foreach($orders as $order)
            <div>
                <a class="font-weight-light text-secondary" href="{{ route('order.show', $order->id) }}">Order №{{ $order->id }}</a>
            </div>
        @endforeach
    </div>
@endsection