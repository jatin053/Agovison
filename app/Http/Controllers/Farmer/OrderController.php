<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request, OrderRepository $orderRepository): View
    {
        return view('farmer.orders.index', [
            'filters' => $request->only(['search', 'status', 'payment_status']),
            'orders' => $orderRepository->farmer(auth()->user(), $request->all()),
        ]);
    }
}
