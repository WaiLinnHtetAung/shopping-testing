<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductOrder extends Notification
{
    use Queueable;
    private $orderSuccessData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderSuccessData)
    {
        $this->orderSuccessData = $orderSuccessData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->orderSuccessData['body'])
                    ->action($this->orderSuccessData['orderSuccessText'],
                    $this->orderSuccessData['url'])
                    ->line($this->orderSuccessData['thankyou']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
