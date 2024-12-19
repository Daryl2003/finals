@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card mb-4 shadow-sm">
        <div style="background: linear-gradient(90deg, rgb(206, 151, 151) 0%, rgb(158, 75, 75) 100%);" class="card-header text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0"><i class="fas fa-cogs"></i> Manage Products</h2>
            <a style="background: grey; "href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Product
            </a>
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
                <table class="table table-bordered table-striped">
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
                                        <span class="text-decoration-line-through text-muted">₱{{ number_format($product->price, 2) }}</span>
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
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- You can add any specific JS for the product management page here -->
@endsection
