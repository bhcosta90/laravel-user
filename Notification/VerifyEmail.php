<?php


namespace Costa\User\Notification;

use Illuminate\Auth\Notifications\VerifyEmail as V;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends V implements ShouldQueue
{
    use Queueable;
}
