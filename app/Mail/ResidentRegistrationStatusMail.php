<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResidentRegistrationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $resident,
        public string $status,
        public ?string $reason = null,
        public ?string $loginUrl = null,
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved'
            ? 'Registration Approved - Barangay Bagacay'
            : 'Registration Rejected - Barangay Bagacay';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.resident-registration-status',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
