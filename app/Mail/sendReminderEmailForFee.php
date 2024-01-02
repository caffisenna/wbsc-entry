<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendReminderEmailForFee extends Mailable
{
    use Queueable, SerializesModels;
    protected $entryInfo;
    protected $cat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($entryInfo,$cat)
    {
        $this->entryInfo = $entryInfo;
        $this->cat = $cat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminderEmailForFee')
        ->subject('指導者研修 参加費未納のお知らせ')
        ->with('entryInfo', $this->entryInfo)
        ->with('cat', $this->cat);
    }
}
