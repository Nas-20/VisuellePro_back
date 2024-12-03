<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        Mail::send('emails.test', [], function ($message) {
            $message->to('votre_email@example.com')
                    ->subject('Test Email Laravel');
        });

        return response()->json(['message' => 'Email envoyé avec succès !']);
    }
}

