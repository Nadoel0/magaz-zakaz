@extends('layouts.app')

@section('content')
    <div class="form-group mb-3">
        <form action="{{ route('basket.store', $order->id) }}" method="post">
            <label>Products</label>
            <select multiple class="form-select" name="product_id">
                @foreach($products as $product)
                    <option {{ old('$product_id') == $product -> id ? 'selected' : '' }} value="{{ $product -> id }}">
                        {{ $product -> name }} {{ $product -> price }}
                    </option>
                @endforeach
            </select>
            <div class="form-group mt-3">
                <label>Comment</label>
                <textarea name="comment" class="form-control" placeholder="Comment"></textarea>
            </div>
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="price" value="{{ $product->price }}">
            <button type="submit" class="btn btn-outline-secondary mt-3">Done</button>
        </form>
    </div>
@endsection
