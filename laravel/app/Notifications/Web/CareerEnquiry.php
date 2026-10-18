<?php

namespace App\Notifications\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CareerEnquiry extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Career Form Enquiry')
                    ->line('Name : '. $this->data['name'])
                    ->line('Email : '. $this->data['email'])
                    ->line('Phone : '. $this->data['phone'])
                    ->line('Role : '. $this->data['role'])
                    ->attach( $this->data['resume']->getRealPath(), [
                        'as' =>  $this->data['resume']->getClientOriginalName(),
                        'mime' =>  $this->data['resume']->getClientMimeType(),
                    ]);
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
