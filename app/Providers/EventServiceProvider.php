<?php

namespace App\Providers;

use App\Events\CropApproved;
use App\Events\OrderPlaced;
use App\Listeners\SendCropApprovedNotifications;
use App\Listeners\SendOrderPlacedNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        CropApproved::class => [
            SendCropApprovedNotifications::class,
        ],
        OrderPlaced::class => [
            SendOrderPlacedNotifications::class,
        ],
    ];
}
