<?php

namespace App\Listeners;

use App\Mail\OtpCodeMail;
use App\Events\OtpCodeStoredEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToUser implements ShouldQueue
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
     * @param  OtpCodeStoredEvent  $event
     * @return void
     */
    public function handle(OtpCodeStoredEvent $event)
    {
        Mail::to($event->otpCode->user->email)
	        ->send(new OtpCodeMail($event->otpCode , $event->newUserStatus));
    }
}
 