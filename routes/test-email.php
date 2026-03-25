<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/test-email', function () {
    $testEmail = request('email', auth()->user()?->email ?? 'test@example.com');
    
    try {
        Mail::raw('This is a test email from GoldVault. If you received this, your email configuration is working!', function ($message) use ($testEmail) {
            $message->to($testEmail)
                    ->subject('Test Email - GoldVault');
        });
        
        return 'Test email sent to: ' . $testEmail . '<br>Check your inbox (and spam folder)!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
