<?php

namespace App\Http\Util;

use Illuminate\Notifications\Notifiable;
use App\Notifications\Slack;

class SlackPost
{
    use Notifiable;

    public function send($message)
    {
        $this->notify(new Slack($message));
    }

    protected function routeNotificationForSlack()
    {
        return config('slack.url');
    }
}
