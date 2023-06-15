@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <h2>Create order</h2>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Name</label>
                <input readonly name="name" class="form-control" placeholder="Enter name" value="Заказ № xz">

                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label>Customer</label>
                <select class="form-select" name="customer_id">
                    @foreach($customers as $customer)
                        <option {{ old('$customer_id') == $customer -> id ? 'selected' : '' }} value="{{ $customer -> id }}">
                            {{ $customer -> name }} {{ $customer -> surname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Shop</label>
                <select class="form-select" name="shop_id">
                    @foreach($shops as $shop)
                        <option {{ old('$shop_id') == $shop -> id ? 'selected' : '' }} value="{{ $shop -> id }}">
                            {{ $shop -> name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input name="status" value="1" type="hidden">
            <button type="submit" class="btn btn-outline-secondary">Next</button>
        </form>
    </div>
@endsection
