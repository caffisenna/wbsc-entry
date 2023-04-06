<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GmRequest extends Mailable
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
        return $this->view('mail.gm_request')
            ->subject('WB研修所 参加承認のお願い')
            ->with('name', $this->name)->with('uuid', $this->uuid);
    }
}
