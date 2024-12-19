@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('cart.view') }}" class="btn btn-secondary mb-3" style="position: absolute; top: 20px; left: 20px;">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    
    <h1 class="text-center mb-5">Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row g-4">
            <!-- Payment Method -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header payment-header d-flex align-items-center">
                        <i class="fas fa-credit-card me-2"></i>
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="payment_method">Choose Payment Method:</label>
                            <select name="payment_method" class="form-control" required id="payment-method">
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        <!-- PayPal Logo -->
                        <div class="text-center mt-4">
                            <table border="0" cellpadding="10" cellspacing="0" align="center">
                                <tr>
                                    <td align="center"></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- End of PayPal Logo -->
                    </div>
                </div>
            </div>

            <!-- Your Cart Items -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header cart-header d-flex align-items-center">
                        <i class="fas fa-shopping-cart me-2"></i>
                        <h5 class="mb-0">Your Cart Items</h5>
                    </div>
                    <div class="card-body">
                        @if(count($cart) > 0)
                            <ul class="list-group mb-3">
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $item)
                                    @php
                                        $itemPrice = isset($item['discount']) ? $item['price'] : $item['price'];
                                        $subtotal = $itemPrice * $item['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item['name'] }}</strong><br>
                                            <small>Quantity: {{ $item['quantity'] }}</small>
                                            <span class="d-block">
                                                Price: ₱{{ number_format($item['price'], 2) }}
                                                @if(isset($item['discount']) && $item['discount'] > 0)
                                                    <span class="badge bg-warning text-dark">Discounted</span>
                                                @endif
                                            </span>
                                        </div>
                                        <span>Subtotal: ₱{{ number_format($subtotal, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="text-end">
                                <h4>Total Amount Payable: ₱{{ number_format($total, 2) }}</h4>
                                <input type="hidden" name="total_amount" value="{{ number_format($total, 2, '.', '') }}">
                            </div>
                        @else
                            <p>Your cart is empty.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-success btn-lg px-5 py-3 shadow">Place Order</button>
        </div>
    </form>
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
    }
    .card-header {
        font-size: 1.1rem;
        font-weight: bold;
    }
    .payment-header {
        background-color: rgb(153, 85, 85);
        color: #fff;
    }
    .cart-header {
        background-color: rgb(155, 85, 85);
        color: #fff;
    }
    .btn-lg {
        font-size: 1.25rem;
    }
    .btn-success {
        background-color: rgb(161, 90, 90);
        border-color:rgb(255, 255, 255);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .btn-success:hover {
        background-color: #000000;
        transform: translateY(-2px);
    }
    .list-group-item {
        transition: background-color 0.3s ease;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle form submission with SweetAlert confirmation
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        event.preventDefault();
        // Show confirmation SweetAlert for PayPal checkout
        Swal.fire({
            title: "Redirecting to PayPal",
            text: "Please wait while we process your payment.",
            icon: "info",
            iconColor: "#426b1f",
            confirmButtonColor: "#426b1f",
            showConfirmButton: false,
            timer: 2000,
        }).then(() => {
            window.location.href = "{{ route('checkout.paypal') }}";
        });
    });
</script>
@endsection
