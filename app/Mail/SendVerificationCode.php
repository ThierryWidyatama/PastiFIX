<?php

namespace App\Mail;

use App\Models\User; // <-- PENTING
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    // [BARU] Buat properti publik untuk nampung data
    public $user;
    public $code;

    /**
     * [BARU] Buat konstruktor untuk nerima data dari controller
     */
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Verifikasi Akun PastiFIX Anda', // [BARU] Tambah subjek
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // [BARU] Arahkan ke view blade yang kita buat
        return new Content(
            view: 'emails.send_verification',
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