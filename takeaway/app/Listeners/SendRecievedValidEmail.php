<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\ValidEmailRequestRecieved;
use Illuminate\Support\Facades\Mail;
use App\Traits\LogSendStatus;

//use App\Mail\UserSubscribed;


class SendRecievedValidEmail
{
    
     use LogSendStatus;

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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
     
        $mailableClass= $event->emailData['mailable']; 
        $mailableClassFullName = "\App\Mail\\".$mailableClass;
        
        $status = 'Sent';
        Mail::to($event->emailData['email'])->queue(new $mailableClassFullName($event->emailData));
        $sent =  $this->updateLogStatus($event->emailData, $status);
      
        //\Log::info('mail user',['mail'=> $event->emailData['email'], 'status'=> $status, 'data'=> $event->emailData]);
        
         // check for failures
        if (Mail::failures()) {
            //log mail failure
            $status = 'Failed';
            $failed =  $this->updateLogStatus($event->emailData, $status);
        }
    }
}
