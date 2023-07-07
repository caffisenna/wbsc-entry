<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrainerConfirm extends Mailable
{
    use Queueable, SerializesModels;
    protected $name, $uuid;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $uuid)
    {
        $this->name = $name;
        $this->uuid = $uuid;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '指導者訓練課題 トレーナー認定完了のお知らせ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('mail.trainer_confirm')
            ->with('name', $this->name)
            ->with('uuid', $this->uuid);
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
