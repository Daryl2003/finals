@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert2 CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container my-5">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3" style="position: absolute; top: 20px; left: 20px;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <!-- Product Card -->
        <div class="row">
            <div class="col-md-6">
                <div class="product-image text-center">
                    <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/300x300' }}" class="card-img-top img-fluid" alt="{{ $product->product_name }}"
                         class="img-fluid rounded" 
                         alt="{{ $product->product_name }}"
                         style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 10px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <h1 class="display-4">{{ $product->product_name }}</h1>

                    @if ($product->discount > 0)
                        <!-- Display Discounted Price -->
                        <h3 class="text-muted">
                            <del>₱{{ number_format($product->price, 2) }}</del>
                            <span class="text-danger">
                                {{ $product->discount }}% Off
                            </span>
                        </h3>
                        @php
                            $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
                        @endphp
                        <h3 class="text-success">
                            ₱{{ number_format($discountedPrice, 2) }}
                        </h3>
                    @else
                        <!-- Display Regular Price if No Discount -->
                        <h3 class="text-muted">₱{{ number_format($product->price, 2) }}</h3>
                    @endif

                    <p class="mt-3">
                        <strong>Description:</strong><br>
                        {{ $product->description }}
                    </p>

                    @if($product->stock > 0)
                        <p>
                            <strong>Stock Available:</strong> {{ $product->stock }}
                        </p>

                        @if(Auth::check() && Auth::user()->role !== 'admin')
                            <!-- Quantity Selector -->
                            <div class="quantity-selector my-3 d-flex align-items-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                                <input type="text" id="quantity" name="quantity" value="1" readonly 
                                       class="mx-2 text-center form-control" style="width: 60px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                            </div>

                            <!-- Add to Cart Button -->
                            <form id="addToCartForm" action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" id="quantityInput" value="1">
                                <button type="submit" class="btn btn-success btn-lg mt-2">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        @endif
                    @else
                        <p class="text-danger"><strong>Out of Stock</strong></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details Tabbed Section -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="related-tab" data-toggle="tab" href="#related" role="tab" aria-controls="related" aria-selected="false">Related Products</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="productTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <p>No reviews yet.</p>
                    </div>
                    <div class="tab-pane fade" id="related" role="tabpanel" aria-labelledby="related-tab">
                        <p>Check out similar products.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantity Selector Script -->
    <script>
        function changeQuantity(amount) {
            let quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);

            // Adjust quantity with limits
            let newQuantity = currentQuantity + amount;
            if (newQuantity > 0 && newQuantity <= {{ $product->stock }}) {
                quantityInput.value = newQuantity;
                document.getElementById('quantityInput').value = newQuantity; // Sync with hidden input for form submission
            }
        }

        // Add event listener for Add to Cart form submission
        document.getElementById('addToCartForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            // Show SweetAlert confirmation with custom icon and button colors
            Swal.fire({
                title: "Order added to cart.",
                text: "Go to Checkout",
                icon: "success",
                iconColor: "#426b1f", // Set the icon color to #426b1f
                confirmButtonColor: "#426b1f" // Set the OK button color to #426b1f
            }).then((result) => {
                // If user clicks "OK", submit the form
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
