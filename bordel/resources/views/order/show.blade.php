@extends('layouts.app')

@section('content')
    <style>
        .box {
            background-color: gainsboro;
        }

        .tble {
            background-color: deepskyblue;
            width: 50%;
        }

        .cl {
            background-color: mediumpurple;
            border: 10px solid deepskyblue;
            color: white;
            text-align: center;
        }

        .rw {
            background-color: lightblue;
            border: 10px solid deepskyblue;
            text-align: center;
        }

        .btn-del {
            background-color: red;
            border: 10px solid deepskyblue;
            color: white;
            text-align: center;
            width: 1px;
        }
    </style>
    <div class="box">
        <table class="tble">
            <thead>
            <tr>
                <th class="cl">id</th>
                <th class="cl">product name</th>
                <th class="cl">price</th>
                <th class="cl">interact</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th class="rw">1</th>
                <th class="rw">pizza</th>
                <th class="rw">370</th>
                <th class="btn-del">X</th>
            </tr>
            <tr>
                <th class="rw">2</th>
                <th class="rw">burger</th>
                <th class="rw">150</th>
                <th class="btn-del">X</th>
            </tr>
            </tbody>
        </table>
    </div>
{{--    <div>--}}
{{--        <form action="{{ route('basket.store', $order->id) }}" method="post">--}}
{{--            @csrf--}}
{{--            <label>Products</label>--}}
{{--            <select multiple class="form-select" name="product_id[]">--}}
{{--                @foreach($products as $product)--}}
{{--                    <option value="{{ $product->id }}">--}}
{{--                        {{ $product->name }}: {{ $product->price }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <div class="form-group mt-3">--}}
{{--                <label>Comment</label>--}}
{{--                <textarea name="comment" class="form-control" placeholder="Comment"></textarea>--}}
{{--            </div>--}}
{{--            <input type="hidden" name="order_id" value="{{ $order->id }}">--}}
{{--            <input type="hidden" name="user_id" value="{{ $user->id }}">--}}
{{--            <button type="submit" class="btn btn-outline-secondary mt-3">Done</button>--}}
{{--        </form>--}}
{{--    </div>--}}
@endsection
