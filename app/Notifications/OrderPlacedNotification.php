<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly Order $order,
        public readonly string $audience = 'buyer',
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Update: '.$this->order->order_number)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->audience === 'farmer'
                ? 'A new crop order has been assigned to you on AgroVision.'
                : 'Your order has been placed successfully on AgroVision.')
            ->line('Order #: '.$this->order->order_number)
            ->line('Invoice #: '.$this->order->invoice_number)
            ->line('Total: INR '.number_format((float) $this->order->total_amount, 2))
            ->action('View Order', url('/'))
            ->line('Thank you for growing with AgroVision.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order',
            'title' => 'Order '.$this->order->order_number,
            'message' => $this->audience === 'farmer'
                ? 'A new marketplace order needs your attention.'
                : 'Your order was placed successfully.',
            'order_id' => $this->order->id,
            'action_url' => route($this->audience === 'farmer' ? 'farmer.orders.index' : 'buyer.orders.index'),
        ];
    }
}
