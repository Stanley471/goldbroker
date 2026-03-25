@extends('emails.layout')

@section('title', 'KYC Documents Received')

@section('content')
<h2 style="margin-top: 0; color: #D4AF37;">KYC Documents Received</h2>

<p>Hi {{ $user->first_name ?? $user->name }},</p>

<p>Thank you for submitting your KYC documents. We've received your verification request and it's now under review.</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Submission ID:</span>
        <span class="value">#{{ $submission->id }}</span>
    </div>
    <div class="info-row">
        <span class="label">Submitted At:</span>
        <span class="value">{{ $submission->created_at->format('M d, Y H:i') }}</span>
    </div>
    <div class="info-row">
        <span class="label">Status:</span>
        <span class="value">Under Review</span>
    </div>
</div>

<p>Our team will review your documents within 24-48 hours. You will receive an email notification once the verification is complete.</p>

<p>Please ensure that:</p>
<ul style="color: #A0A0A0;">
    <li>Your documents are clear and readable</li>
    <li>All four corners of ID documents are visible</li>
    <li>Your selfie clearly shows your face</li>
</ul>

<center>
    <a href="{{ route('kyc.index') }}" class="button">Check Status</a>
</center>

<p>Best regards,<br>The GoldVault Team</p>
@endsection
