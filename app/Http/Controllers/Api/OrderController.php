<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, OrderRepository $orderRepository): JsonResponse
    {
        $user = $request->user();

        $orders = $user->hasRole('Farmer')
            ? $orderRepository->farmer($user, $request->all())->items()
            : $orderRepository->buyer($user, $request->all())->items();

        return response()->json(['data' => $orders]);
    }

    public function store(CheckoutRequest $request, OrderService $orderService): JsonResponse
    {
        try {
            $orders = $orderService->checkout($request->user(), $request->validated());

            return response()->json([
                'message' => 'Orders created successfully.',
                'data' => $orders,
            ], 201);
        } catch (\RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return response()->json([
            'data' => $order->load(['items.crop', 'payment', 'buyer', 'farmer']),
        ]);
    }
}
