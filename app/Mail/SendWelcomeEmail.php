<?php

namespace App\Mail;

use App\Models\User; // <-- PENTING
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    // [BARU] Buat properti publik
    public $user;

    /**
     * [BARU] Buat konstruktor
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang di PastiFIX!', // [BARU] Tambah subjek
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // [BARU] Arahkan ke view blade
        return new Content(
            view: 'emails.send_welcome',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}