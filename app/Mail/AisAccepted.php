<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AisAccepted extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $flag;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $flag)
    {
        $this->name = $name;
        $this->flag = $flag;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->flag == 'accept') {
            return $this->view('emails.ais_accepted')
                ->subject('ウッドバッジ研修所の参加決定について')
                ->with('name', $this->name);
        } elseif ($this->flag == 'reject') {
            return $this->view('emails.ais_rejected')
                ->subject('ウッドバッジ研修所の参加否認について')
                ->with('name', $this->name);
        }
    }
}
