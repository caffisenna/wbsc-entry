<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GmRequest extends Mailable
{
    use Queueable, SerializesModels;
    protected $name, $uuid, $gm_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gm_name, $uuid, $name)
    {
        $this->gm_name = $gm_name;
        $this->uuid = $uuid;
        $this->name = $name;
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
            ->with('name', $this->name)->with('uuid', $this->uuid)
            ->with('gm_name', $this->gm_name);
    }
}
