<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user()->weatherLogs()->latest()->take(20)->get(),
        ]);
    }

    public function store(Request $request, WeatherService $weatherService): JsonResponse
    {
        $validated = $request->validate([
            'location' => ['required', 'string', 'max:255'],
        ]);

        $log = $weatherService->fetchAndStore($validated['location'], $request->user());

        return response()->json([
            'message' => 'Weather log stored successfully.',
            'data' => $log,
        ], 201);
    }
}
