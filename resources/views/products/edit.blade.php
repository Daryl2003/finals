@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">


    
    <div class="card p-5 shadow-lg">
        <h2 class="text-center mb-4">Edit Product</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Product Edit Form -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="product_name" class="form-label">Product Name:</label>
                <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" placeholder="Enter product name">
            </div>

            <div class="form-group mb-4">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Describe your product">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group mb-4">
                <label for="price" class="form-label">Price:</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" placeholder="Enter price">
            </div>

            <div class="form-group mb-4">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" placeholder="Enter stock quantity">
            </div>

            <div class="form-group mb-4">
                <label for="image" class="form-label">Product Image:</label>
                <input type="file" name="image" class="form-control-file">
                @if($product->image_path)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->product_name }}" width="100" class="rounded shadow-sm">
                    </div>
                @endif
            </div>

            <!-- Discount Form -->
            <div class="form-group mb-4">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount" value="{{ old('discount', $product->discount) }}" class="form-control" step="0.01" min="0" max="100" placeholder="Enter discount percentage">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg shadow">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f9f9f9;
    }

    .card {
        border-radius: 10px;
        max-width: 600px;
        margin: auto;
        background-color: #ffffff;
    }

    h2 {
        font-family: 'Newsreader', serif;
        font-size: 2rem;
        color: #426b1f;
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        border-radius: 8px;
        box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #426b1f;
        border: none;
        font-size: 1.1rem;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #333;
        transform: scale(1.05);
    }

    .shadow-sm {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
