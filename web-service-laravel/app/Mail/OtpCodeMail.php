<?php

namespace App\Mail;

use App\OtpCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode , $newUserStatus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OtpCode $otpCode , $newUserStatus)
    {
        $this->otpCode = $otpCode;
        $this->newUserStatus = $newUserStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.otpCode.mail');
        
    }
}
