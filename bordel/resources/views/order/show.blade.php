@extends('layouts.app')

@section('content')
    <div>
        <form>
            <div class="form-group">
                <label>Order №{{ $order->id }}</label>
            </div>
        </form>
    </div>
@endsection
