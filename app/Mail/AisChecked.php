<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AisChecked extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ais_checked')
        ->subject('スカウトコース参加申込 AIS委員会確認のお知らせ')
        ->with('name', $this->name);
    }
}
