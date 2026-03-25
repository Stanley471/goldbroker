@extends('emails.layout')

@section('title', 'Deposit Pending')

@section('content')
<h2 style="margin-top: 0; color: #D4AF37;">Deposit Pending</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>We've received your deposit request. Your funds are being processed and will be added to your wallet once confirmed.</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Reference Number:</span>
        <span class="value">#{{ $transaction->reference_number ?? $transaction->id }}</span>
    </div>
    <div class="info-row">
        <span class="label">Amount:</span>
        <span class="value highlight">${{ number_format($transaction->amount ?? 0, 2) }}</span>
    </div>
    <div class="info-row">
        <span class="label">Payment Method:</span>
        <span class="value">{{ ucfirst($paymentMethod ?? 'N/A') }}</span>
    </div>
    <div class="info-row">
        <span class="label">Status:</span>
        <span class="value">Pending</span>
    </div>
    <div class="info-row">
        <span class="label">Date:</span>
        <span class="value">{{ $transaction->created_at->format('M d, Y H:i') }}</span>
    </div>
</div>

<p>We will notify you once your deposit has been confirmed and the funds are available in your wallet.</p>

<center>
    <a href="{{ route('wallet.index') }}" class="button">View Wallet</a>
</center>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
