@extends('emails.layout')

@section('title', 'KYC Verification Approved')

@section('content')
<h2 style="margin-top: 0; color: #D4AF37;">🎉 KYC Verification Approved!</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>Congratulations! Your identity verification has been approved. Your account is now fully verified.</p>

<div class="info-box" style="background-color: #1a3a1a; border-color: #4CAF50;">
    <div class="info-row">
        <span class="label">Status:</span>
        <span class="value" style="color: #4CAF50; font-weight: bold;">✓ VERIFIED</span>
    </div>
    <div class="info-row">
        <span class="label">Verified At:</span>
        <span class="value">{{ now()->format('M d, Y H:i') }}</span>
    </div>
</div>

<p>With a verified account, you can now:</p>
<ul style="color: #ffffff;">
    <li>Make unlimited deposits and withdrawals</li>
    <li>Purchase precious metals without restrictions</li>
    <li>Access all platform features</li>
</ul>

<center>
    <a href="{{ route('dashboard') }}" class="button">Go to Dashboard</a>
</center>

<p>Thank you for completing the verification process!</p>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
