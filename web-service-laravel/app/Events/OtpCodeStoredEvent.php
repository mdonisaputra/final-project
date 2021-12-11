<?php

namespace App\Events;

use App\OtpCode;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OtpCodeStoredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $otpCode , $newUserStatus;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OtpCode $otpCode , $newUserStatus = false)
    {
        $this->otpCode = $otpCode;
        $this->newUserStatus = $newUserStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
}
