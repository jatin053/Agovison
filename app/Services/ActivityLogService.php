<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function log(string $type, string $description, ?Model $subject = null, ?User $user = null, array $meta = []): Activity
    {
        $activity = new Activity([
            'type' => $type,
            'description' => $description,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'meta' => $meta,
        ]);

        if ($subject) {
            $activity->subject()->associate($subject);
        }

        if ($user) {
            $activity->user()->associate($user);
        }

        $activity->save();

        return $activity;
    }
}
