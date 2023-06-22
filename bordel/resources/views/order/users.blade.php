@extends('layouts.app')

@section('content')
    <div>
        <h2>Add customers in order</h2>
        <form action="{{ route('order.users') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Customer</label>
                <select multiple class="form-select" name="user_id[]">
                    @foreach($users as $user)
                        <option value="{{ $user -> id }}">
                            {{ $user -> name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input name="order_id" value="{{ $order->id }}" type="hidden">
            <button type="submit" class="btn btn-outline-secondary">Create</button>
        </form>
    </div>
@endsection
