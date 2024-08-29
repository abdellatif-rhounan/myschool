<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ForgotPasswordMail extends Mailable
{
    protected $name;
    protected $remember_token;

    public function __construct($name, $remember_token)
    {
        $this->name = $name;
        $this->remember_token = $remember_token;
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
                'name' => $this->name,
                'remember_token' => $this->remember_token,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
