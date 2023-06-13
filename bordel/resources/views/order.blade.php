@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <h2>Create person</h2>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Name</label>
                <input name="name" class="form-control" placeholder="Enter name">

                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label>Customer</label>
                <select class="custom-select" name="customer_id">
                    @foreach($customers as $customer)
                        <option {{ old('$customer_id') == $customer -> id ? 'selected' : '' }} value="{{ $customer -> id }}">
                            {{ $customer -> name }} {{ $customer -> surname }}
                        </option>
                    @endforeach
                </select>

                @error('customer_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-outline-secondary">Create</button>
        </form>
    </div>
@endsection
