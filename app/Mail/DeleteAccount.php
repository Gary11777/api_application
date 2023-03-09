<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeleteAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $pdf)
    {
        $this->email = $email;
        $this->pdf = $pdf;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Delete Account',
            to: $this->email
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.delete.account',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromData(fn () => $this->pdf, 'delete_data.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
