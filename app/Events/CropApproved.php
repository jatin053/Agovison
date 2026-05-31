<?php

namespace App\Events;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CropApproved
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public readonly Crop $crop,
        public readonly User $admin,
    ) {
    }
}
