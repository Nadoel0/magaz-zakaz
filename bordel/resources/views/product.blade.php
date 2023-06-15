@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <h2>Create order</h2>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Product</label>
                <select class="form-select" name="product_id">
                    @foreach($products as $product)
                        <option {{ old('$product_id') == $product -> id ? 'selected' : '' }} value="{{ $product -> id }}">
                            Продукт: {{ $product -> name }}
                            Цена: {{ $product -> price }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input name="name" value="Заказ №{{ $order -> id }}" type="hidden">
            <input name="status" value="2" type="hidden">
            <button type="submit" class="btn btn-outline-secondary">Create</button>
        </form>
    </div>
@endsection
