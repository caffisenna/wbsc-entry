<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommiChecked extends Mailable
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
        return $this->view('emails.commi_checked')
        ->subject('指導者訓練参加 地区コミッショナー推薦完了のお知らせ')
        ->with('name', $this->name);
    }
}
