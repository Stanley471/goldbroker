<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KycApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        
        \Log::info('[EMAIL] KycApproved email queued', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'KYC Verification Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.kyc-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
