@extends('layouts.app')

@section('content')
    <div>
        <h2>Создание заказа</h2>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label>Имя заказа</label>
                <input name="name" class="form-control" placeholder="Введите имя заказа">
            </div>
            <div class="form-group mb-3">
                <input type="hidden" name="owner_id" value="{{ $owner->id }}">
            </div>
            <div class="form-group mb-3">
                <label>Клиенты</label>
                <select multiple class="form-select" name="user_id[]">
                    @foreach($users as $user)
                        <option value="{{ $user -> id }}">
                            {{ $user -> name }} {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input name="status" value="1" type="hidden">
            <button type="submit" class="btn btn-outline-secondary">Next</button>
        </form>
    </div>
@endsection
