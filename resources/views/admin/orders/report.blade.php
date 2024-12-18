@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Sales Report</h2>

        <!-- Print Button -->
        <div class="text-end mb-3">
            <button onclick="printReport()" class="btn btn-primary">Print Report</button>
        </div>

        <!-- Sales Report Table -->
        <div id="report-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($completedOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ $order->total_amount }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function printReport() {
        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        var content = document.getElementById('report-content').innerHTML;

        // Write the content to the new window
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Sales Report</title>
                <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Include any required stylesheets -->
                <style>
                    /* Add any additional print styles here */
                    body { font-family: Arial, sans-serif; }
                    .table { width: 100%; border-collapse: collapse; }
                    .table, .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
                    .table th { background-color: #f8f9fa; }
                </style>
            </head>
            <body>
                <h2 class="text-center">Sales Report</h2>
                ${content}
            </body>
            </html>
        `);
        printWindow.document.close();

        // Trigger the print dialog
        printWindow.print();

        // Close the print window after printing
        printWindow.onafterprint = function() {
            printWindow.close();
        };
    }
</script>
@endsection
