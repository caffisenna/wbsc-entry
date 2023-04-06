<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainerRequest extends Mailable
{
    use Queueable, SerializesModels;
    protected $name, $uuid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $uuid)
    {
        $this->name = $name;
        $this->uuid = $uuid;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.trainer_request')
            ->subject('WB研修所課題研修 トレーナー認定のお願い')
            ->with('name', $this->name)->with('uuid', $this->uuid);
    }
}
