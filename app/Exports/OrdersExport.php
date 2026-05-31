<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @param  Collection<int, Order>|null  $orders
     */
    public function __construct(
        private readonly ?Collection $orders = null,
    ) {
    }

    /**
     * @return Collection<int, Order>
     */
    public function collection(): Collection
    {
        return $this->orders
            ?? Order::query()->with(['buyer', 'farmer'])->latest()->get();
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'Order Number',
            'Invoice Number',
            'Buyer',
            'Farmer',
            'Status',
            'Payment Status',
            'Total Amount',
            'Created At',
        ];
    }

    /**
     * @return array<int, string|float|null>
     */
    public function map($row): array
    {
        return [
            $row->order_number,
            $row->invoice_number,
            $row->buyer?->name ?? '-',
            $row->farmer?->name ?? '-',
            $row->status,
            $row->payment_status,
            (float) $row->total_amount,
            $row->created_at?->format('Y-m-d H:i'),
        ];
    }
}
