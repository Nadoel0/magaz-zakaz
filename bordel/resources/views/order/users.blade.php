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
        <button onclick="storeUsers()" class="btn btn-outline-secondary">Create</button>
    </div>
    <script>
        function storeUsers() {
            let users_id = [];
            $('#user_id').each(function(user) {
                console.log(user);
            })


            let order_id = $('#order_id').val();

            $.ajax({
                url: '{{ route('order.users', $order->id) }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: 1,
                    order_id: order_id
                },
                success: function(response) {
                    console.log(response);
                },
            });
        };
    </script>
@endsection
