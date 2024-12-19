@extends('admin.layouts.app') <!-- Extend the admin layout -->

@section('content')
    <div class="container">
        <!-- Admin Dashboard Header -->
        <div class="dashboard-box shadow-lg p-4 mb-5 rounded">
            <h1 class="text-center mb-4" style="font-weight: bold; color: #444;">Admin Dashboard</h1>

            <!-- Dashboard Cards Row -->
            <div class="row text-center">

                <!-- Manage Users -->
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title text-dark font-weight-bold mb-3">Manage Users</h5>
                            <p class="card-text text-secondary">View, edit, and manage users of the system.</p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-dark">Manage Users</a>
                        </div>
                    </div>
                </div>

                <!-- Manage Products -->
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title text-dark font-weight-bold mb-3">Manage Products</h5>
                            <p class="card-text text-secondary">View, edit, and manage products in store.</p>
                            <a href="{{ route('home') }}" class="btn btn-sm btn-dark">Manage Products</a>
                        </div>
                    </div>
                </div>

                <!-- Manage Orders -->
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title text-dark font-weight-bold mb-3">Manage Orders</h5>
                            <p class="card-text text-secondary">View, edit, and manage customer orders.</p>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-dark">Manage Orders</a>
                        </div>
                    </div>
                </div>

                <!-- Manage Categories -->
                <div class="col-md-3 mb-4">
                    <div class="card dashboard-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title text-dark font-weight-bold mb-3">Manage Categories</h5>
                            <p class="card-text text-secondary">Add, edit, and manage product categories.</p>
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-dark">Manage Categories</a>
                        </div>
                    </div>
                </div>

            </div> <!-- End Row -->
        </div> <!-- End Dashboard Box -->
    </div>
@endsection

@section('styles')
<style>
    /* Dashboard Container */
    .dashboard-box {
        background-color:rgb(0, 0, 0);
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    /* Dashboard Card Styling */
    .dashboard-card {
        background: white;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Card Title */
    .dashboard-card .card-title {
        font-size: 18px;
        color: #333;
    }

    /* Card Buttons */
    .btn-dark {
        background-color: #444;
        border: none;
    }

    .btn-dark:hover {
        background-color: #222;
        color: #fff;
    }

    /* Container Background */
    body {
        background: linear-gradient(to right,rgb(0, 0, 0),rgb(212, 0, 0));
    }
</style>
@endsection
