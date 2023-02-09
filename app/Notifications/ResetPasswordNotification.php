<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
  use Queueable;

  protected $url;

  public function __construct(string $url)
  {
    $this->url = $url;
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->line('Forgot Password?')
      ->line('Reset Link: ' . $this->url)
      ->line('Thank you for using our application!');
  }

  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
