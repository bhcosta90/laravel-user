<?php

namespace Costa\User\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class UserSendPassword extends Notification
{
    use Queueable;

    private $password;
    private $isNew;

    public function __construct(string $password, bool $isNew = true)
    {
        $this->password = $password;
        $this->isNew = $isNew;
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
        $password = $this->password;

        $url = config('app.url');
        $message = $this->isNew
            ? Lang::get('We create your user in our system with the password: **:password**', ['password' => $password])
            : Lang::get('We edit the password of the user to **:password**', ['password' => $password]);

        return (new MailMessage)
            ->subject(Lang::get('My Password'))
            ->line($message)
            ->action(Lang::get('Access system'), $url)
            ->line(Lang::get('If you did not request a new user, no further action is required.'));
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
