<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function latest(Request $request): JsonResponse
    {
        $notifications = $request->user()->unreadNotifications()->take(10)->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? 'Notification',
                'message' => $notification->data['message'] ?? 'You have a new update.',
                'action_url' => $notification->data['action_url'] ?? '#',
                'created_at' => $notification->created_at?->diffForHumans(),
            ];
        });

        return response()->json([
            'count' => $request->user()->unreadNotifications()->count(),
            'items' => $notifications,
        ]);
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'Notifications marked as read.']);
    }
}
