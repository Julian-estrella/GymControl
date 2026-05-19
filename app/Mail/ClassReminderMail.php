<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $gymClass;
    public $client;
    public $classTime;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\GymClass $gymClass, \App\Models\Client $client, string $classTime)
    {
        $this->gymClass = $gymClass;
        $this->client = $client;
        $this->classTime = $classTime;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio de Clase: ' . $this->gymClass->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.classes.reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
