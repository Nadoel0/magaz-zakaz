@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <form action="{{ route('customer.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Customer</label>
                <select class="form-select" name="customer_id">
                    @foreach($customers as $customer)
                        <option {{ old('$customer_id') == $customer -> id ? 'selected' : '' }} value="{{ $customer -> id }}">
                            {{ $customer -> name }} {{ $customer -> surname }}
                        </option>
                    @endforeach
                </select>
                <a class="btn btn-outline-secondary">Register person</a>
            </div>
            <input type="hidden" name="order_id" value="{{ $order -> id }}">
            <button type="submit" class="btn btn-outline-secondary">Next</button>
        </form>
    </div>
@endsection
