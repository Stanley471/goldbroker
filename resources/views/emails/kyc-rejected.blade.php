@extends('emails.layout')

@section('title', 'KYC Verification Requires Attention')

@section('content')
<h2 style="margin-top: 0; color: #D4AF37;">KYC Verification Requires Attention</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>We reviewed your KYC submission, but unfortunately, we couldn't verify your identity at this time.</p>

<div class="info-box" style="background-color: #3a1a1a; border-color: #f44336;">
    <div class="info-row">
        <span class="label">Status:</span>
        <span class="value" style="color: #f44336; font-weight: bold;">✗ REJECTED</span>
    </div>
    @if($submission->admin_notes)
    <div class="info-row" style="flex-direction: column;">
        <span class="label">Reason:</span>
        <span class="value" style="margin-top: 8px; color: #f44336;">{{ $submission->admin_notes }}</span>
    </div>
    @endif
</div>

<p>Common reasons for rejection:</p>
<ul style="color: #A0A0A0;">
    <li>Document image is blurry or unclear</li>
    <li>Information doesn't match your account details</li>
    <li>Document has expired</li>
    <li>Selfie doesn't match the ID photo</li>
</ul>

<p>Please review the feedback above and submit new documents that address these issues.</p>

<center>
    <a href="{{ route('kyc.create') }}" class="button">Resubmit Documents</a>
</center>

<p>If you have any questions, please contact our support team.</p>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
