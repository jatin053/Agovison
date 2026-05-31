<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasActivityFeed
{
    public function activityFeed(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
