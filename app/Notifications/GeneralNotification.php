<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GeneralNotification extends Notification
{
    use Queueable;

    /**
     * Default message notification.
     *
     * @var string
     */
    private $message = '';

    /**
     * Notification icon.
     *
     * @var string
     */
    private $icon = 'fa-bell';

    /**
     * Link to notification.
     *
     * @var string
     */
    private $link = '';

    /**
     * Create a new notification instance.
     */
    public function __construct(string $message, string $link = '', string $icon = 'fa-bell')
    {
        $this->icon = $icon;
        $this->message = $message;
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }

    /**
     * Send notification to database.
     *
     * @param object $notifiable
     */
    public function toDatabase($notifiable): array
    {
        return [
            'icon' => $this->icon,
            'message' => $this->message,
            'link' => $this->link,
        ];
    }
}
