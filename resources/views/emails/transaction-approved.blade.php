@extends('emails.layout')

@section('title', 'Transaction Approved')

@section('content')
<h2 style="margin-top: 0; color: #D4AF37;">Transaction Approved!</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>Your transaction has been reviewed and approved by our team.</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Reference Number:</span>
        <span class="value">#{{ $transaction->reference_number ?? $transaction->id }}</span>
    </div>
    <div class="info-row">
        <span class="label">Type:</span>
        <span class="value">{{ ucfirst(str_replace('_', ' ', $transaction->type ?? 'transaction')) }}</span>
    </div>
    <div class="info-row">
        <span class="label">Amount:</span>
        <span class="value highlight">${{ number_format($transaction->amount ?? 0, 2) }}</span>
    </div>
    <div class="info-row">
        <span class="label">Status:</span>
        <span class="value" style="color: #4CAF50;">Approved</span>
    </div>
    <div class="info-row">
        <span class="label">Approved At:</span>
        <span class="value">{{ $transaction->updated_at->format('M d, Y H:i') }}</span>
    </div>
</div>

<p>The transaction has been processed and your account has been updated accordingly.</p>

<center>
    <a href="{{ route('wallet.index') }}" class="button">View Wallet</a>
</center>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
