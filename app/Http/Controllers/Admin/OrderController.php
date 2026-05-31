<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrderController extends Controller
{
    public function index(Request $request, OrderRepository $orderRepository): View
    {
        return view('admin.orders.index', [
            'filters' => $request->only(['search', 'status', 'payment_status']),
            'orders' => $orderRepository->admin($request->all()),
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download(new OrdersExport(), 'agrovision-orders.xlsx');
    }
}
