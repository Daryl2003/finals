@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-center align-items-center">
            <h1 class="mb-0"><i class="fas fa-cogs mr-2"></i> Manage Products</h1> <!-- 'mr-2' adds a margin between icon and text -->
        </div>

        <div class="card-body">         
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    @if($product->discount)
                                        <span style="text-decoration: line-through;">₱{{ number_format($product->price, 2) }}</span>
                                        ₱{{ number_format($product->price - ($product->price * ($product->discount / 100)), 2) }}
                                    @else
                                        ₱{{ number_format($product->price, 2) }}
                                    @endif
                                </td>
                                <td>
                                    @if($product->discount)
                                        {{ $product->discount }}%
                                    @else
                                        No Discount
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No products available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- You can add any specific JS for the product management page here -->
@endsection
