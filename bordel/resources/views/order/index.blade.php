@extends('layouts.app')

@section('content')
    <div>
        @foreach($orders as $order)
            <div>
                <a>Order №{{ $order->id }}</a>
            </div>
        @endforeach
    </div>
@endsection
