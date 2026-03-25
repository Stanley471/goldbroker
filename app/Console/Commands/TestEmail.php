<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test {email?}';
    protected $description = 'Send a test email to verify configuration';

    public function handle(): int
    {
        $email = $this->argument('email') ?? config('mail.from.address');
        
        $this->info("Sending test email to: {$email}");
        
        try {
            Mail::raw('This is a test email from GoldVault. If you received this, your email configuration is working!', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - GoldVault');
            });
            
            $this->info('✓ Test email sent successfully!');
            $this->info("Check {$email} inbox (and spam folder)");
            
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('✗ Failed to send email');
            $this->error($e->getMessage());
            
            return self::FAILURE;
        }
    }
}
