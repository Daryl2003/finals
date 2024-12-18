@extends('layouts.app')

@section('content')
<div class="container my-5">

    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-4" style="position: absolute; top: 20px; left: 20px;">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">My Orders</h2>
    </div>

    @forelse ($orders as $order)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><strong>Order #{{ $order->user_order_id }}</strong></h5>
                </div>
                <div>
                    <span class="badge {{ $order->shipping_status === 'delivered' ? 'bg-success' : ($order->shipping_status === 'pending' ? 'bg-warning' : 'bg-info') }}">
                        {{ ucfirst($order->shipping_status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="fw-bold">Products:</h5>
                        @if(!empty($order->product_details))
                            <ul class="list-group list-group-flush">
                                @foreach ($order->product_details as $product)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><strong>{{ $product['name'] }}</strong></span>
                                        <span class="text-muted">${{ number_format($product['price'], 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No products in this order.</p>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="mt-3">
                            <h5 class="fw-bold">Order Summary</h5>
                            <div class="mb-2">
                                <span class="text-muted">Order Status:</span> 
                                <strong>{{ ucfirst($order->shipping_status) }}</strong>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Payment Method:</span> 
                                <strong>{{ ucfirst($order->payment_method) }}</strong>
                            </div>
                            <div>
                                <span class="text-muted">Total Amount:</span> 
                                <strong class="text-primary">${{ number_format($order->total_amount, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted text-end">
                <small>Order Date: {{ $order->created_at->format('M d, Y - h:i A') }}</small>
            </div>
        </div>
    @empty
        <div class="alert alert-warning" role="alert">
            You haven't placed any orders yet.
        </div>
    @endforelse
</div>
@endsection
