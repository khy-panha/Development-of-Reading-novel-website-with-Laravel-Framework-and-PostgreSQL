<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Pass the token when creating the notification
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Choose where the notification goes (email)
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the email message
     */
    public function toMail($notifiable)
    {
        $url = url('/reset-password/' . $this->token . '?email=' . urlencode($notifiable->email));
    
        return (new MailMessage)
            ->subject('Reset Password')
            ->line('Click the button below to reset your password.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.');
    }
    

    /**
     * Optional array format
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
