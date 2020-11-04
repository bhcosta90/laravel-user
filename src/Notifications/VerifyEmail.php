<?php

namespace BRCas\User\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as V;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends V implements ShouldQueue
{
    use Queueable;
}
