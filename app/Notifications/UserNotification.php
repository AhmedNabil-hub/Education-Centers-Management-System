<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
	public $data;

	public function __construct($data)
	{
		$this->data = $data;
	}


	public function via($notifiable)
	{
		return ['database'];
	}

	public function toArray($notifiable)
	{
		return $this->data;
	}
}
