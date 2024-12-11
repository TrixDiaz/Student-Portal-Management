<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateUser extends Notification
{
    use Queueable;

    public $user;
    public $plainPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Welcome to our Golden Gate College!')
            ->line('Your account has been created successfully.')
            ->line('Your Name is ' . $this->user->name)
            ->line('Your Email is ' . $this->user->email)
            ->line('Your Password is ' . $this->plainPassword)
            ->action('Login', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New user ' . $this->user->name . ' created',
            'url' => route('admin.users.edit', $this->user->id),
        ];
    }
}
