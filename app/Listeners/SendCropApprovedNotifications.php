<?php

namespace App\Listeners;

use App\Events\CropApproved;
use App\Notifications\CropApprovedNotification;
use App\Services\ActivityLogService;

class SendCropApprovedNotifications
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
    public function handle(CropApproved $event): void
    {
        $event->crop->farmer?->notify(new CropApprovedNotification($event->crop, $event->admin));

        $this->activityLogService->log(
            'notification.crop_approved',
            'Crop approval notification sent.',
            $event->crop,
            $event->admin
        );
    }
}
