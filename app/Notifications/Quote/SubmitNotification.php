<?php

namespace App\Notifications\Quote;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Quote;

class SubmitNotification extends Notification
{
    use Queueable;

    /**
     * Quote object model.
     *
     * @var Quote
     */
    private $quote;

    /**
     * Create a new notification instance.
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
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
        return ['mail', 'database'];
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
            ->subject(__('New Quote has been Submitted'))
            ->markdown('mails.quote.submit', [
                'quote' => $this->quote,
            ]);
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
            'icon' => 'fa-quote-right',
            'message' => __('New quote has been submitted.'),
            'link' => route('admin.quote.edit', $this->quote),
        ];
    }
}
