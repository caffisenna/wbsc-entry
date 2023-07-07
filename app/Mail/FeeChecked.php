<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeChecked extends Mailable
{
    use Queueable, SerializesModels;
    protected $name, $cat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $cat)
    {
        $this->name = $name;
        $this->cat = $cat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.feechecked')
            ->subject('指導者訓練 入金確認のお知らせ')
            ->with('name', $this->name)
            ->with('cat', $this->cat);
    }
}
