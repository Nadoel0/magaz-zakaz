@extends('layouts.app')

@section('content')
    <div>
        <h2>Create order</h2>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Name</label>
                <input name="name" class="form-control" placeholder="Enter name">
            </div>
            <div class="form-group mb-3">
                <label>Owner</label>
                <input class="form-control" placeholder="{{ $owner->name }} {{ $owner->email }}">
                <input type="hidden" name="owner_id" value="{{ $owner->id }}">
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
