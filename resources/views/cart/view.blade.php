@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4 display-4">Your Shopping Cart</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row g-4">
            <!-- Shopping Cart Items -->
            @php $grandTotal = 0; @endphp
            @foreach(session('cart') as $id => $item)
                @php
                    $itemTotal = $item['price'] * $item['quantity'];
                    $grandTotal += $itemTotal;
                @endphp
                <div class="col-md-6 col-lg-4 mb-4"> <!-- Added bottom margin here -->
                    <div class="card h-100 shadow-sm card-spacing"> <!-- Added custom class for spacing -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark">{{ $item['name'] ?? 'Unknown Product' }}</h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-dark fw-bold">₱{{ number_format($item['price'], 2) }}</span>
                                <span class="text-muted text-decoration-line-through">₱{{ number_format($item['original_price'], 2) }}</span>
                            </div>
                            <p class="card-text">
                                <strong>Quantity:</strong> <span class="badge bg-secondary">{{ $item['quantity'] }}</span>
                            </p>
                            <p class="card-text"><strong>Subtotal:</strong> ₱{{ number_format($itemTotal, 2) }}</p>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-success btn-sm w-100"><i class="fas fa-trash-alt"></i> Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Amount and Actions -->
        <div class="d-flex flex-column align-items-end mt-5">
            <div class="text-end w-100">
                <h4 class="fw-bold">Total Amount Payable: ₱{{ number_format($grandTotal, 2) }}</h4>
            </div>
            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg mt-3"><i class="fas fa-check-circle"></i> Proceed to Checkout</a>
            <a href="{{ route('products.index') }}" class="btn btn-success btn-lg mt-2"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
        </div>
    @else
        <!-- Empty Cart Message -->
        <div class="text-center py-5">
            <p class="h5">Your cart is empty. Start adding items to enjoy your shopping experience!</p>
            <a href="{{ route('products.index') }}" class="btn btn-success mt-3">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
    .container h1 {
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        color: #333;
    }
    .card {
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;    
        box-shadow: 0 15px 30px rgba(46, 46, 46, 0.2);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 5px 15px rgba(59, 58, 58, 0.1);
        background-color:rgb(250, 248, 248);
    }
    .card-title {
        font-size: 1.25rem;
    }
    .text-decoration-line-through {
        text-decoration: line-through;
    }
    .btn-outline-primary, .btn-success {
        font-size: 1.1rem;
    }
    .btn-success {
        background-color: rgb(150, 88, 88);
        border-color: #ffffff;
        transition: background-color 0.3s ease;
    }
    .btn-success:hover {
        background-color: #060605;
    }
    .card-spacing {
        margin-top: 20px; /* Adjust this value for more or less space */
    }
</style>
@endsection
