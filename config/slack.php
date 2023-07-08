<?php

return [

    /*
    独自の定数を設定
    呼び出しは config('slack.channel') など
    */

    'channel' => 'project-wb申込通知',
    'name' => '通知Bot',
    'url' => env('SLACK_URL'),
];
