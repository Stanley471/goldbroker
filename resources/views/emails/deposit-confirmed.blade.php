@extends('emails.layout')

@section('title', 'Deposit Confirmed')

@section('content')
<h2 style="margin-top: 0; color: #D4AF37;">Deposit Confirmed!</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>Great news! Your deposit has been confirmed and the funds are now available in your wallet.</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Reference Number:</span>
        <span class="value">#{{ $transaction->reference_number ?? $transaction->id }}</span>
    </div>
    <div class="info-row">
        <span class="label">Amount Deposited:</span>
        <span class="value highlight">${{ number_format($transaction->amount, 2) }}</span>
    </div>
    <div class="info-row">
        <span class="label">New Balance:</span>
        <span class="value highlight">${{ number_format($user->wallet?->usd_balance ?? $user->wallet?->balance_usd ?? 0, 2) }}</span>
    </div>
    <div class="info-row">
        <span class="label">Confirmed At:</span>
        <span class="value">{{ $transaction->updated_at->format('M d, Y H:i') }}</span>
    </div>
</div>

<p>You can now use these funds to purchase precious metals or hold them in your wallet.</p>

<center>
    <a href="{{ route('products.index') }}" class="button">Browse Products</a>
</center>

<p>Thank you for choosing GoldVault!</p>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
