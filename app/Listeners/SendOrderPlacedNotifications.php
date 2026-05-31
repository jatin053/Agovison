<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\OrderPlacedNotification;
use App\Services\ActivityLogService;

class SendOrderPlacedNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly ActivityLogService $activityLogService,
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $event->order->buyer?->notify(new OrderPlacedNotification($event->order, 'buyer'));
        $event->order->farmer?->notify(new OrderPlacedNotification($event->order, 'farmer'));

        $this->activityLogService->log(
            'notification.order_placed',
            'Order placed notifications sent.',
            $event->order,
            $event->order->buyer
        );
    }
}
