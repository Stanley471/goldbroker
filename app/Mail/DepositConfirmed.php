<?php

namespace App\Mail;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DepositConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public Transaction $transaction;

    public function __construct(User $user, Transaction $transaction)
    {
        $this->user = $user;
        $this->transaction = $transaction;
        
        // Load wallet relationship for email template
        $this->user->load('wallet');
        
        \Log::info('[EMAIL] DepositConfirmed email queued', [
            'user_id' => $user->id,
            'email' => $user->email,
            'transaction_id' => $transaction->id
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Deposit Confirmed - #' . $this->transaction->reference_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deposit-confirmed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
