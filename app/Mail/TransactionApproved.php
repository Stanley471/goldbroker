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

class TransactionApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public Transaction $transaction;

    public function __construct(User $user, Transaction $transaction)
    {
        $this->user = $user;
        $this->transaction = $transaction;
        
        \Log::info('[EMAIL] TransactionApproved email queued', [
            'user_id' => $user->id,
            'email' => $user->email,
            'transaction_id' => $transaction->id
        ]);
    }

    public function envelope(): Envelope
    {
        $type = ucfirst(str_replace('_', ' ', $this->transaction->type));
        return new Envelope(
            subject: $type . ' Approved - #' . $this->transaction->reference_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
