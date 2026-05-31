@extends('layouts.app')

@php($pageTitle = 'Invoice '.$order->invoice_number)
@php($pageSubtitle = 'Order receipt ready for print or PDF export.')

@section('content')
    @include('buyer.orders.invoice-pdf', ['order' => $order])
@endsection
