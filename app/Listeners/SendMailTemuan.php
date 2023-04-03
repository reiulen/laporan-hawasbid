<?php

namespace App\Listeners;

use App\Events\SendEmailTemuan;
use App\Mail\TemuanEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailTemuan implements ShouldQueue
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
     * @param  \App\Events\SendEmailTemuan  $event
     * @return void
     */
    public function handle(SendEmailTemuan $event)
    {
        $user = $event->data;
        Mail::to($user->email)->send(new TemuanEmail($user));
    }
}
