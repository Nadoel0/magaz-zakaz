@extends('layouts.main')

@section('content')
    <div class="mt-3">
        <form action="{{ route('customer.store') }}" id="form" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Customer</label>
                <select multiple class="custom-select" name="person_id">
                    @foreach($customers as $customer)
                        <option value="{{ $customer -> id }}">
                            {{ $customer -> name }} {{ $customer -> surname }}
                        </option>
                    @endforeach
                </select>

                <input name="addPerson" class="btn btn-outline-secondary mt-3" value="Add person">
            </div>
            <input type="hidden" name="order_id" value="{{ $order -> id }}">
            <button type="submit" class="btn btn-outline-secondary">Next</button>
        </form>
    </div>
@endsection
