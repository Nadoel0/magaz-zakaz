@extends('layouts.main')

@section('content')
    <div class="mt-3">
        @foreach($orders as $order)
            <div>
                <a class="font-weight-light text-secondary">Order №{{ $order -> id }}</a>
            </div>
        @endforeach
    </div>
    <div>
        <a href="{{ route('order.create') }}" class="btn btn-outline-secondary mt-3">Create order</a>
    </div>
@endsection
