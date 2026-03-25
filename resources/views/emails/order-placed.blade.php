@extends('emails.layout')

@section('title', 'Order Confirmation')

@section('content')
@php
// Debug: Log what we received
\Log::info('[EMAIL TEMPLATE] OrderPlaced view data', [
    'order_object' => $order->toArray() ?? 'NULL',
    'reference_number' => $order->reference_number ?? 'NULL',
    'total_usd' => $order->total_usd ?? 'NULL',
    'delivery_method' => $order->delivery_method ?? 'NULL',
    'status' => $order->status ?? 'NULL'
]);

// Ensure we have the order data loaded
$orderRef = $order->reference_number ?? $order->id ?? 'N/A';
$orderTotal = $order->total_usd ?? $order->total ?? 0;
$orderMethod = $order->delivery_method ?? 'standard';
$orderStatus = $order->status ?? 'pending';
@endphp

<h2 style="margin-top: 0; color: #D4AF37;">Order Confirmed!</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>Thank you for your order. We've received your purchase and are processing it now.</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Reference Number:</span>
        <span class="value">#{{ $orderRef }}</span>
    </div>
    <div class="info-row">
        <span class="label">Order Date:</span>
        <span class="value">{{ $order->created_at ? $order->created_at->format('M d, Y') : now()->format('M d, Y') }}</span>
    </div>
    <div class="info-row">
        <span class="label">Total Amount:</span>
        <span class="value highlight">${{ number_format($orderTotal, 2) }}</span>
    </div>
    <div class="info-row">
        <span class="label">Delivery Method:</span>
        <span class="value">{{ ucfirst($orderMethod) }}</span>
    </div>
    <div class="info-row">
        <span class="label">Status:</span>
        <span class="value">{{ ucfirst($orderStatus) }}</span>
    </div>
</div>

<p>You can view your order details and track its progress by clicking the button below:</p>

<center>
    <a href="{{ route('dashboard') }}" class="button">View Order</a>
</center>

<p>If you have any questions about your order, please contact our support team.</p>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
