<?php

namespace App\Notifications;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CropApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly Crop $crop,
        public readonly User $admin,
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
            ->subject('Crop Approved: '.$this->crop->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Your crop listing has been approved by the AgroVision admin team.')
            ->line('Crop: '.$this->crop->title)
            ->action('Manage Inventory', route('farmer.crops.index'))
            ->line('Keep your inventory updated for better buyer conversions.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'crop',
            'title' => 'Crop approved',
            'message' => $this->crop->title.' is now live in the marketplace.',
            'crop_id' => $this->crop->id,
            'action_url' => route('farmer.crops.index'),
        ];
    }
}
