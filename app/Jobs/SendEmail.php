<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Notification\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Queueable;

    private $User;
    private $mailable;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Mailable $mailable)
    {
        $this->User = $user ;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(Notification $notification)
    {
        return $notification->sendEmail($this->User, $this->mailable);
    }
}
