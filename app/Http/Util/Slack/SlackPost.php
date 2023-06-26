<?php

namespace App\Http\Util\Slack;

use Illuminate\Notifications\Notifiable;
use App\Notifications\SlackNotification;

class SlackPost
{
    use Notifiable;

    public function send($message)
    {
        $this->notify(new SlackNotification($message));
    }

    protected function routeNotificationForSlack()
    {
        return env('SLACK_URL');
    }
}

