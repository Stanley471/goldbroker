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

class DepositInitiated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public Transaction $transaction;
    public string $paymentMethod;

    public function __construct(User $user, Transaction $transaction, string $paymentMethod)
    {
        $this->user = $user;
        $this->transaction = $transaction;
        $this->paymentMethod = $paymentMethod;
        
        \Log::info('[EMAIL] DepositInitiated email queued', [
            'user_id' => $user->id,
            'email' => $user->email,
            'transaction_id' => $transaction->id
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Deposit Pending - ' . ucfirst($this->paymentMethod),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deposit-initiated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
