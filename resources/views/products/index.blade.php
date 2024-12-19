@extends('layouts.app')

@section('content')
    <!-- Header Design -->
    <div class="rectangle">
        <span class="swing-arm-shop">ALLOY SWING ARM SHOP</span>
        <div class="header-links">
            @if(Auth::check() && Auth::user()->role !== 'admin')
                <a href="{{ route('myorders.index') }}" style="color:white;" class="orders">
                    <i class="fas fa-box"></i>
                </a>
                <a href="{{ route('notifications.view') }}" style="color:white;" class="notification">
                    <i class="fas fa-bell"></i>
                </a>
            @endif

            @if(Auth::check())
                <!-- Dropdown for Cart, Profile, Logout -->
                <div class="dropdown d-inline-block">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
                        @if(Auth::check() && Auth::user()->role !== 'admin')
                            <a class="dropdown-item" href="{{ route('cart.view') }}">Cart</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                </div>
            @endif

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Sorting options and Category Filter side by side on the left -->
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
                <!-- Sort By Dropdown -->
                <div class="dropdown mr-3">
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

                <!-- Category Filter with Subcategories -->
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
        <h1 class="text-center mb-4 swing-arm-heading">PRODUCT LIST</h1>
    
        <!-- Product Box -->
        <div class="product-box">
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm product-card">
                            <div class="card-img-container">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/300x300' }}" class="card-img-top img-fluid" alt="{{ $product->product_name }}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                
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
    </div>
@endsection

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, rgb(250, 250, 250), rgb(128, 10, 6));
        height: 100vh;
    }

    .rectangle {
        position: relative;
        width: 100%;
        height: 100px;
        background: rgb(167, 87, 87);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 50px;
        margin-bottom: 60px;
        box-shadow: 0 15px 16px rgba(0, 0, 0, 0.2);
    }

    .product-box {
        background: linear-gradient(135deg, rgb(131, 44, 44), rgb(170, 94, 94));   
    }

    .swing-arm-shop {
        font-family: 'Newsreader', serif;
        font-size: 40px;
        color: rgb(255, 255, 255);
    }

    .header-links a {
        margin-left: 60px;
        font-family: 'Inter', sans-serif;
        font-size: 16px;
        color: black;
        text-decoration: none;
    }

    .header-links a:hover {
        text-decoration: underline;
    }

    .product-card {
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 5px;
        box-shadow: 0 15px 16px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        background-color: lightgray;
    }

    .card-img-container img {
        transition: transform 0.3s ease;
        border-radius: 10px 10px 0 0;
    }

    .card-img-container:hover img {
        transform: scale(1.1);
    }

    .swing-arm-heading {
        font-family: 'Newsreader', serif;
        font-size: 40px;
        color: black;
    }

    .btn-info {
        background-color: rgb(110, 110, 110);
        border: none;
        color: white;
    }

    .btn-info:hover {
        background-color: black;
    }

    .btn-success {
        background-color: rgba(245, 0, 0, 0.58);
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: black;
    }

    .product-box {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 20px;
        background-color: rgba(252, 252, 252, 0.8);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
    }

    /* Dropdown button styling */
    .btn-secondary {
        background-color: #6c757d; /* Bootstrap default gray */
        border: none;
        border-radius: 50%; /* Circular button */
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff; /* White icon color */
        transition: all 0.3s ease-in-out;
    }

    .btn-secondary:hover,
    .btn-secondary:focus {
        background-color: #343a40; /* Darker gray */
        color: #f8f9fa; /* Light color on hover */
        outline: none; /* Remove default focus border */
    }

    /* Dropdown menu styling */
    .dropdown-menu {
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        border: none;
        padding: 0; /* Remove default padding */
        overflow: hidden; /* For rounded corners */
        min-width: 150px;
    }

    .dropdown-menu .dropdown-item {
        font-size: 14px;
        color: #333; /* Dark gray text */
        padding: 10px 15px;
        transition: background 0.3s ease-in-out, color 0.3s;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa; /* Light gray hover */
        color: #007bff; /* Bootstrap primary blue */
    }

    .dropdown-divider {
        margin: 0; /* Clean divider without spacing */
        border-color: rgba(0, 0, 0, 0.1);
    }

    /* Logout link special style */
    .dropdown-item:active,
    .dropdown-item:focus {
        background-color: #e74c3c; /* Red color for logout */
        color: #fff;
    }

</style>
@endsection
