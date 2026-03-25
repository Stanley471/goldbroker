<?php

namespace App\Mail;

use App\Models\KycSubmission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KycRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public KycSubmission $submission;

    public function __construct(User $user, KycSubmission $submission)
    {
        $this->user = $user;
        $this->submission = $submission;
        
        \Log::info('[EMAIL] KycRejected email queued', [
            'user_id' => $user->id,
            'email' => $user->email,
            'submission_id' => $submission->id
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'KYC Verification Requires Attention',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.kyc-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
