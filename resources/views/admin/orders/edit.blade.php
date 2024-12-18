@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Order #{{ $order->id }}</h1>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="shipping_status">Shipping Status:</label>
            <select name="shipping_status" class="form-control" required>
                <option value="Pending" {{ $order->shipping_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Shipped" {{ $order->shipping_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="Delivered" {{ $order->shipping_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Status</button>
    </form>

</div>
@endsection