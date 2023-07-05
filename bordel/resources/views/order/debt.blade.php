@extends('layouts.app')

@section('content')
    <div>
        <h3>Choose who paid</h3>
        <form class="form-control" action="{{ route('order.complete', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            @foreach($users as $user)
                <div class="form-check mb-3 mt-3">
                    <input class="form-check-input" type="checkbox" name="paidUsers[]" value="{{ $user->user->id }}">
                    <label class="form-check-label">{{ $user->user->name }} {{ $user->user->email }}</label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-success">End order</button>
        </form>
    </div>
@endsection
