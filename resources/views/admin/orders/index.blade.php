@extends('admin.layouts.app')

@section('content')
<div  class="container-fluid">
    <div class="card mb-4">
        <div style="background:rgb(167, 87, 87);" class="card-header
         text-white d-flex justify-content-center align-items-center">
            <h1 class="mb-0"><i class="fas fa-box-open mr-2"></i> Manage Orders</h1> <!-- 'mr-2' adds a margin between icon and text -->
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
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Total Amount</th>
                            <th>Shipping Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->shipping_status }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('admin.orders.report') }}" class="btn btn-info mb-3">
                    <i class="fas fa-chart-line"></i> View Reports
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- You can add any specific JS for the orders management page here -->
@endsection
