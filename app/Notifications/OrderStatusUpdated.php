<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Sends both email and database notifications
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Order Status Updated')
                    ->line("Your order status has been updated to: {$this->status}")
                    ->action('View Order', url('/orders'))
                    ->line('Thank you for shopping with us!');
    }

    public function toArray($notifiable)
            {
    return [
        'order_id' => $this->status->id,
        'user_id' => $this->status->user_id,
        'total_amount' => $this->status->total_amount,
        'shipping_status' => $this->status->shipping_status,
        'message' => "Your order (ID: {$this->status->id}) status has been updated to: {$this->status->shipping_status}.",
    ];
}
}
