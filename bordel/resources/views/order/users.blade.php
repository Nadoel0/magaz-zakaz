@extends('layouts.app')

@section('content')
    <div>
        <h2>Add customers in order</h2>
        @csrf
        <label>Customers:</label>
        @foreach($users as $user)
            <div>
                <input type="checkbox" id="user_id" name="user" value="{{ $user->id }}">
                <label for="user">{{ $user->name }}: {{ $user->email }}</label>
            </div>
        @endforeach
        <input name="order_id" value="{{ $order->id }}" type="hidden">
        <button onclick="storeUser()" class="btn btn-outline-secondary">Create</button>
    </div>
    <script>
        function storeUser() {
            let user_id = [];
            let users = $('.user');
            let users_ = [];
            users.each(function () {
                console.log($(this).val());
                console.log($(this).prop('checked'));
                if($(this).prop('checked')) users_.push($(this).val);

            });
            console.log(users_);

            let order_id = $('#order_id').val();
        }

        {{--$.ajax({--}}
        {{--    url: '{{ route('order.store') }}',--}}
        {{--    method: 'POST',--}}
        {{--    data: {--}}
        {{--        --}}
        {{--    }, // Передать данные для отправки--}}
        {{--    success: function(response) {--}}
        {{--        // Обработка успешного ответа от сервера--}}
        {{--        console.log(response);--}}
        {{--    },--}}
    </script>
@endsection
