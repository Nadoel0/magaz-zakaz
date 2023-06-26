@extends('layouts.app')

@section('content')
    <style>
        .box-all {
            display: flex;
            margin-top: 20px;
            height: 400px;
            border-radius: 7px;
        }

        .box-table {
            border-radius: 7px;
            background-color: deepskyblue;
            width: 50%;
            margin: 0 5px 0 15px;
            display: grid;
        }

        .box-table-user {
            border-radius: 7px;
            margin: 0 15px 0 5px;
            width: 50%;
        }

        .for-table1 {
            background-color: deepskyblue;
            height: 370px;
            border-radius: 7px;
            padding: 7px;
        }

        .for-user {
            background-color: orange;
            /*margin-bottom: 5px;*/
            height: 35%;
            border-radius: 7px;
            display: grid;
        }

        .for-table2 {
            background-color: #9f57ef;
            /*margin-top: 5px;*/
            height: 65%;
            border-radius: 7px;
        }

        .table1 {
            width: 100%;
            border-spacing: 15px;
            border-collapse: separate;
        }

        .user {
            height: 110px;
            background-color: orange;
            border-radius: 7px;
        }

        .table2 {
            /*margin-top: 30px;*/
            /*width: 100%;*/
            border-spacing: 15px;
        }

        .th {
            background-color: mediumpurple;
            text-align: center;
            color: white;
            border-radius: 7px;
        }

        .td {
            text-align: center;
            background-color: #a1e7ff;
            border-radius: 7px;
        }

        .btn-del {
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            font-size: 15px;
            display: inline-block;
        }

        .id-th {
            background-color: mediumpurple;
            color: white;
            width: 20px;
            border-radius: 7px;
            padding: 5px;
        }

        .interact-th {
            background-color: mediumpurple;
            color: white;
            width: 20px;
            border-radius: 7px;
            padding: 5px;
            font-size: 10px;
        }

        p {
            margin: 15px 0 0 15px;
            font-size: 15px;
        }
    </style>
    <div class="box-all">
        <div class="box-table">
            <div class="for-table1">
                <table class="table1">
                    <thead>
                    <tr>
                        <th class="id-th">id</th>
                        <th class="th">product name</th>
                        <th class="th">price</th>
                        <th class="interact-th">interact</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="td">1</td>
                        <td class="td">burger</td>
                        <td class="td">170</td>
                        <td>
                            <button class="btn-del">X</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td">2</td>
                        <td class="td">pizza</td>
                        <td class="td">340</td>
                        <td>
                            <button class="btn-del">X</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <button>add</button>
            </div>
        </div>
        <div class="box-table-user">
            <div class="for-user">
                <div>
                    <button>edit</button>
                </div>
                <div class="user">
                    <p>Order name: Order №1</p>
                    <p>Order status: Created</p>
                </div>
            </div>
            <div class="for-table2">
                <div>
                    <button>add</button>
                </div>
                <table class="table2">
                    <tbody>
                    <tr>
                        <td class="td">Nadoelo nadoelo@mail.ru</td>
                        <td>
                            <button class="btn-del">X</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td">Roman romka@mail.ru</td>
                        <td>
                            <button class="btn-del">X</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
