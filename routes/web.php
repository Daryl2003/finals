<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\SellerController; // Import SellerController
use App\Http\Controllers\CustomerController; // Import CustomerController
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController; // Import OrderController
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MyOrdersController; // Import OrderController
use App\Http\Controllers\CategoryController; // Import OrderController

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Public routes like login and register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Ensure users are authenticated to access these routes
// Ensure users are authenticated to access these routes
Route::middleware(['auth'])->group(function () {
    // Shared dashboard (admin, customer, seller)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto'); // For deleting profile picture
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword'); // For changing password

    // Product management
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::resource('products', ProductController::class); // Protect product routes

    // Cart routes
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');

    // Route to handle PayPal checkout (GET)
    Route::get('/checkout/paypal', [CheckoutController::class, 'paypalCheckout'])->name('checkout.paypal');
    
    // PayPal Success Route (GET)
    Route::get('/checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('checkout.paypal.success');
    
    // PayPal Cancel Route (GET)
    Route::get('/checkout/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('checkout.paypal.cancel');
    
    // Route to process checkout form submission (POST)
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Product buying routes
    Route::post('/products/{id}/buy', [ProductController::class, 'buy'])->name('products.buy');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Notifications route   
    Route::get('/notifications', function () {
        return view('notifications');
    })->name('notifications.view');

    // My Orders routes for users
    Route::get('/myorders', [MyOrdersController::class, 'index'])->name('myorders.index'); // View all past orders for a user
});

    

// Admin Dashboard - Only accessible by Admins
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    Route::resource('categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

});

// Order Management Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin/orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index'); // View all orders
        Route::get('{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit'); // Edit order
        Route::post('{id}/update', [OrderController::class, 'update'])->name('admin.orders.update'); // Update order status
        Route::get('/report', [OrderController::class, 'report'])->name('admin.orders.report'); // View sales report
    });
});
