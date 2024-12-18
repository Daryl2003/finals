@extends('layouts.app')

@section('content')
    <!-- Header Design -->
    <div class="rectangle">
        <span class="thrift-shop">ThriftApparel</span>
        <div class="header-links">
            @if(Auth::check() && Auth::user()->role !== 'admin')
                <a href="{{ route('myorders.index') }}" class="orders">
                    <i class="fas fa-box"></i>
                </a>
                <a href="{{ route('notifications.view') }}" class="notification">
                    <i class="fas fa-bell"></i>
                </a>
                <a href="{{ route('cart.view') }}" class="cart">Cart</a>
            @endif
            <a href="{{ route('profile.show') }}" class="profile">Profile</a>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="admin">Admin</a>
            @endif
            <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Sorting options at the top left corner -->
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By
                    </button>
                    <div class="dropdown-menu" aria-labelledby="sortDropdown">
                        <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'name_asc']) }}">Name: A-Z</a>
                        <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'name_desc']) }}">Name: Z-A</a>
                        <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'price_low_high']) }}">Price: Low to High</a>
                        <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'price_high_low']) }}">Price: High to Low</a>
                        <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'discount']) }}">Best Discounts</a>
                    </div>
                </div>
            </div>

            <!-- Category Filter with Subcategories -->
            <div class="col-md-6 d-flex justify-content-end">
                <form method="GET" action="{{ route('products.index') }}" class="form-inline">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                            @foreach($category->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @if(request('category') == $subcategory->id) selected @endif>
                                    &nbsp;&nbsp;&nbsp;-- {{ $subcategory->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary ml-2">Filter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center mb-4 thrift-store-heading">Welcome to ThriftApparel</h1>
    
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card border-0 shadow-sm product-card">
                        <div class="card-img-container">
                            <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/300x300' }}" class="card-img-top img-fluid" alt="{{ $product->product_name }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            
                            <!-- Display Category with Subcategory -->
                            {{-- <p class="card-text">
                                @if($product->category && !$product->category->parent_id)
                                    Main Category: {{ $product->category->name }}
                                @elseif($product->category && $product->category->parent_id)
                                    Subcategory: {{ $product->category->name }} (Parent: {{ $product->category->parent->name }})
                                @else
                                    No Category
                                @endif
                            </p> --}}
                            
                            <div class="d-flex align-items-center">
                                @if($product->discount)
                                    <p class="card-text mb-0" style="margin-right: 5px; color: black;">
                                        ₱{{ number_format($product->price - ($product->price * ($product->discount / 100)), 2) }}
                                    </p>
                                    <p class="card-text mb-0" style="font-size: 0.8em; text-decoration: line-through; color: black;">
                                        ₱{{ number_format($product->price, 2) }}
                                    </p>
                                @else
                                    <p class="card-text mb-0" style="color: black;">
                                        ₱{{ number_format($product->price, 2) }}
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-block">View Details</a>
                            @if(Auth::check() && Auth::user()->role !== 'admin')
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No products available.</p>
            @endforelse
        </div>
    </div>
@endsection



@section('styles')
<style>
    /* Change background color of the entire page */
    body {
        background-color: white;
    }

    /* Header Styles (ThriftShop, Cart, Profile, etc.) */
    .rectangle {
        position: relative;
        width: 100%;
        height: 100px;
        background: #ffffff;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 50px;
        margin-bottom: 60px;
        box-shadow: 0 15px 16px rgba(0, 0, 0, 0.2);
    }

    .thrift-shop {
        font-family: 'Newsreader', serif;
        font-size: 40px;
        margin-left: 80px;
        color: #426b1f;
    }

    .header-links a {
        margin-left: 60px;
        font-family: 'Inter', sans-serif;
        font-size: 16px;
        color: black;
        text-decoration: none;
    }

    .header-links a:hover {
        text-decoration: underline; /* Underline on hover */
    }

    /* Align notification icon and adjust spacing */
    .header-links .notification,
    .header-links .orders {
        font-size: 18px; /* Make icon slightly larger */
        margin-right: 15px; /* Space between notification and cart */
    }

    /* Product card styles */
    .product-card {
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 5px;
        width: 90%;
        height: auto; /* Adjusted for flexibility */
        box-shadow: 0 15px 16px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        background-color: lightgray; /* Changed to light gray on hover */
    }

    .card-img-container {
         position: relative;
         overflow: hidden;
         border-top-left-radius: 10px;
         border-top-right-radius: 10px;
     }

     .card-img-container img {
         transition: transform 0.3s ease; 
         border-radius: 10px 10px 0 0; 
     }

     .card-img-container:hover img {
         transform: scale(1.1); 
     }

     .card-img-container:active img {
         transform: scale(1.2); 
     }

     /* New font style for "Welcome to the Thrift Store" */
     .thrift-store-heading {
         font-family: 'Newsreader', serif;
         font-size: 40px; 
         color: black; 
     }

     /* Custom styles for "View Details" button */
     .btn-info {
         background-color: #426b1f; 
         border: none; 
         color: white; 
     }

     .btn-info:hover {
         background-color: black; 
     }

     /* Custom styles for "Add to Cart" button */
     .btn-success {
         background-color: #426b1f; 
         border: none; 
         color: white; 
     }

     .btn-success:hover {
         background-color: black; 
     }
     
</style>
@endsection
