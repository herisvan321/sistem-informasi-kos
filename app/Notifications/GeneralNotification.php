<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * General-purpose database notification used across all roles.
 * Stores a title, message, and optional action URL.
 */
class GeneralNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected ?string $actionUrl;

    public function __construct(string $title, string $message, ?string $actionUrl = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
    }

    /**
     * Deliver via the database channel only.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data persisted in the notifications table.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'      => $this->title,
            'message'    => $this->message,
            'action_url' => $this->actionUrl,
        ];
    }
}
