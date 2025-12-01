<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevoColaborador extends Mailable
{
    use Queueable, SerializesModels;

    public $proyecto;

    public function __construct(Proyecto $proyecto)
    {
       $this->proyecto = $proyecto;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Has sido añadido al proyecto: ' . $this->proyecto->titulo . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Esto enlaza a una vista que crearás: emails/nuevo-colaborador.blade.php
            view: 'emails.nuevo-colaborador', 
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
