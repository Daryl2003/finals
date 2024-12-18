@extends('admin.layouts.app') <!-- Extend the admin layout -->

@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Admin Dashboard</h1>

        <div class="row mt-5">
            <!-- Manage Users -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View, edit, and manage users of the system.</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>

            <!-- Manage Products -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Products</h5>
                        <p class="card-text">View, edit, and manage products in store.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Manage Products</a>
                    </div>
                </div>
            </div>

            <!-- Manage Orders -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Orders</h5>
                        <p class="card-text">View, edit, and manage customer orders.</p>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Manage Orders</a>
                    </div>
                </div>
            </div>

            <!-- Manage Categories -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Categories</h5>
                        <p class="card-text">Add, edit, and manage product categories.</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary">Manage Categories</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
