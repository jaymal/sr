<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSubscribed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

      protected $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
        $this->mailData['mailFormat'] = 'text';
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     
        if (isset($this->mailData['mailFormat'])  && $this->mailData['mailFormat']=='txt'){
         
            return $this->view('mails.user-subscribed')
                 ->text('mails.user-subscribed_plain')
                 ->with([                     
                        'email' => $this->mailData['email'],
                    ]);

        }
        return $this->markdown('mails.user-subscribed')
                ->with([                     
                        'email' => $this->mailData['email'],
                    ]);

    }
}
