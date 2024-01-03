<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetNoticeEmailForFee extends Mailable
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
        return $this->view('emails.resetNoticeEmailForFee')
        ->subject('指導者研修 参加費確認取消のお知らせ')
        ->with('entryInfo', $this->entryInfo)
        ->with('cat', $this->cat);
    }
}
