@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Notifications</h2>

        <!-- Notification List -->
        <div class="notifications-list">

            <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3" style="position: absolute; top: 20px; left: 20px;">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @if(auth()->user()->notifications->isEmpty())
                <p class="text-center">You have no notifications.</p>
            @else
                @foreach(auth()->user()->notifications as $notification)
                    <div class="notification-item card mb-3 p-3">
                        <p>{{ $notification->data['message'] }}</p>
                        <span class="text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Basic styling for the notifications page */
    .container {
        max-width: 800px;
    }

    .notifications-list {
        margin-top: 20px;
    }

    .notification-item {
        border-left: 5px solid #426b1f; /* Highlighting each notification */
        background-color: #f9f9f9;
        transition: background-color 0.2s ease-in-out;
    }

    .notification-item:hover {
        background-color: #e0f2e0; /* Slight color change on hover */
    }

    /* Styling for timestamps */
    .text-muted {
        font-size: 0.9em;
    }
</style>
@endsection
