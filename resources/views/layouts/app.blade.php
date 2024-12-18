<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Thrift Store')</title>

    <!-- External Bootstrap 4 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Local custom styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <!-- Additional styles from individual views -->
    @yield('styles')
</head>
<body>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <!-- Additional navigation items can go here -->
            </li>
        </ul>
    </div>
    
    <main class="py-4">
        <!-- Page content -->
        @yield('content')
    </main>

    <!-- External Scripts -->
    <!-- Use jQuery Slim if you only need jQuery for Bootstrap (Bootstrap 4) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Additional jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts defined in individual views -->
    @yield('scripts')
</body>
</html>
