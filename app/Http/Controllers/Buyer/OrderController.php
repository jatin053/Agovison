<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(Request $request, OrderRepository $orderRepository): View
    {
        return view('buyer.orders.index', [
            'filters' => $request->only(['search', 'status', 'payment_status']),
            'orders' => $orderRepository->buyer(auth()->user(), $request->all()),
        ]);
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        return view('buyer.orders.show', [
            'order' => $order->load(['items.crop.images', 'payment', 'farmer']),
        ]);
    }

    public function invoice(Order $order): View
    {
        $this->authorize('view', $order);

        return view('buyer.orders.invoice', [
            'order' => $order->load(['items.crop', 'buyer', 'farmer', 'payment']),
        ]);
    }

    public function downloadPdf(Order $order): Response
    {
        $this->authorize('view', $order);

        $pdf = Pdf::loadView('buyer.orders.invoice-pdf', [
            'order' => $order->load(['items.crop', 'buyer', 'farmer', 'payment']),
            'pdfMode' => true,
        ]);

        return $pdf->download('invoice-'.$order->invoice_number.'.pdf');
    }
}
