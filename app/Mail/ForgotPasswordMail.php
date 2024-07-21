<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ForgotPasswordMail extends Mailable
{
    protected $username;
    protected $token;

    public function __construct($username, $token)
    {
        $this->username = $username;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Request New Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mails.forgot_password',
            with: [
                'username' => $this->username,
                'token' => $this->token,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
