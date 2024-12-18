<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #426b1f;
            padding-top: 20px;
            transition: width 0.3s;
            border-radius: 3px;
            box-shadow: 0 4px 60px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            color: #adb5bd;
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            display: block;
            transition: color 0.2s;
        }

        .sidebar a:hover {
            color: #f8f9fa;
            background-color: #025b30;
        }

        .sidebar a.active {
            color: #f8f9fa;
            background-color: #025b30;
            font-weight: bold;
        }

        .sidebar .sidebar-header {
            color: #f8f9fa;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .content {
            margin-left: 270px; /* Adjusted to give some spacing from the sidebar */
            padding: 20px;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #4e73df;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-radius: 0;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-user-shield"></i> Admin Panel
        </div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}"><i class="fas fa-users"></i> Manage Users</a>
        <a href="{{ route('categories.index')  }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fas fa-box"></i> Manage Categories</a>
        <a href="{{ route('home') }}" class="{{ request()->is('home') ? 'active' : '' }}"><i class="fas fa-box"></i> Manage Products</a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Manage Orders</a>
        <a href="{{ route('products.index') }}" class="{{ request()->is('products.index*') ? 'active' : '' }}">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        
    </div>

    <div class="content">
        <div class="container">
            @yield('content') <!-- This is where the content of each page will be displayed -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
