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
    protected $sc_number;
    protected $division_number;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $flag, $sc_number, $division_number)
    {
        $this->name = $name;
        $this->flag = $flag;
        $this->sc_number = $sc_number;
        $this->division_number = $division_number;
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
                ->with('name', $this->name) // 参加者氏名
                ->with('sc_number', $this->sc_number) // SC期数
                ->with('division_number', $this->division_number); // 課程別回数
        } elseif ($this->flag == 'reject') {
            return $this->view('emails.ais_rejected')
                ->subject('ウッドバッジ研修所の参加否認について')
                ->with('name', $this->name);
        }
    }
}
