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
        ->subject('指導者訓練参加 地区AIS委員長確認完了のお知らせ')
        ->with('name', $this->name);
    }
}
