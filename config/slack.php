<?php
return [
    'name' => '通知Bot',
    'channel' => env('SLACK_CHANNEL_' . config('app.env')),
    'url' => env('SLACK_WEBHOOK_' . config('app.env')),
];
