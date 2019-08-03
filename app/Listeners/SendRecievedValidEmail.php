<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\ValidEmailRequestRecieved;
use Illuminate\Support\Facades\Mail;

//use App\Mail\UserSubscribed;


class SendRecievedValidEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $mailableClass= $event->emailData['mailable']; 
        $mailableClassFullName = "\App\Mail\\".$mailableClass;

        Mail::to('arunajamal@yahoo.com')->send(new $mailableClassFullName($event->emailData));
        //Mail::to($event->emailData['email'])->send(new \App\Mail\UserSubscribed($event->emailData));

      
        \Log::info('mail user',['mail'=> $event->emailData['email']]);
        
         // check for failures
        /*if (Mail::failures()) {
            
            // if( count(Mail::failures()) > 0 ) {

            //    foreach(Mail::failures as $email_address) {
            //        echo "$email_address <br />";
            //     }
            // }
          
            // return response showing failed emails
            //log mail failure
        }*/
    }
}
