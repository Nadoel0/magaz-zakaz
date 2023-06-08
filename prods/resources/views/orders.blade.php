@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter name">
            </div>
            <div class="form-group mb-3">
                <label>Food</label>
                <input type="text" class="form-control" placeholder="Enter food">
            </div>
            <div class="form-group mb-3">
                <label>Drink</label>
                <input type="text" class="form-control" placeholder="Enter drink">
            </div>
            <div class="form-group mb-3">
                <label>Cost</label>
                <input type="text" class="form-control" placeholder="Enter cost">
            </div>
            <button type="submit" class="btn btn-outline-secondary">Place order</button>
            <button type="submit" class="btn btn-outline-secondary">Add person</button>
        </form>
    </div>
@endsection
