@extends('layouts.app')

@section('content')
    <div>
        <form action="{{ route('basket.store', $order->id) }}" method="post">
            @csrf
            <label>Products</label>
            <select multiple class="form-select" name="product_id[]">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}: {{ $product->price }}
                    </option>
                @endforeach
            </select>
            <div class="form-group mt-3">
                <label>Comment</label>
                <textarea name="comment" class="form-control" placeholder="Comment"></textarea>
            </div>
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <button type="submit" class="btn btn-outline-secondary mt-3">Done</button>
        </form>
    </div>
@endsection
