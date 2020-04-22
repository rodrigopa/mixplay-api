<?php

namespace App\Domain\Account\Listeners;

use App\Domain\Account\Events\SignUpEvent;
use App\Domain\Account\Notifications\ConfirmUserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendConfirmUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SignUpEvent  $event
     * @return void
     */
    public function handle(SignUpEvent $event)
    {
        $event->user->notify(new ConfirmUserNotification());
    }
}
