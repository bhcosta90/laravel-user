<?php

namespace Costa\User\Notification;

use Illuminate\Bus\Queueable;
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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $password = $this->password;

        $url = config('app.url');
        $message = $this->isNew
            ? Lang::get('Criamos seu usuário em nosso sistema com a senha: **:password**', ['password' => $password])
            : Lang::get('Editamos a senha do usuário para **:password**', ['password' => $password]);

        return (new MailMessage)
            ->subject(Lang::get('Minha senha'))
            ->line($message)
            ->action(Lang::get('Acesso ao Sistema'), $url)
            ->line(Lang::get('Se você não solicitou um novo usuário, nenhuma ação adicional é necessária.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
