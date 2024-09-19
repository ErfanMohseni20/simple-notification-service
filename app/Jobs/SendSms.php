<?php

namespace App\Jobs;

use App\Models\User;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use App\Services\Notification\Notification;

class SendSms implements ShouldQueue
{
    use Queueable;
    private $user; 
    private $text ;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $text )
    {
        $this->user = $user ;
        $this->text = $text ;
    }

    /**
     * Execute the job.
     */
    public function handle(Notification $notification)
    {
        return $notification->sendSms($this->user , $this->text);
    }
}
