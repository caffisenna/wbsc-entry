<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class SlackNotification extends Notification
{
    use Queueable;
    protected $channel;
    protected $name;
    protected $message;


    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->channel = config('slack.channel');
        $this->name = config('slack.name');
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toSlack($notifiable)
    {
        $message = (new SlackMessage)
            ->from($this->name)
            ->to($this->channel)
            ->content($this->message);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
