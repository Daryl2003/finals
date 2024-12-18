@extends('admin.layouts.app')

@section('content')
    <h1>Delete Product: {{ $product->product_name }}</h1>

    <p>Are you sure you want to delete this product?</p>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Yes, Delete</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
