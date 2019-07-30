<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSubscribed extends Mailable //implements ShouldQueue
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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!isset($this->mailData['mailFormat'])){ //send markdown as defaul
            return $this->markdown('mails.user-subscribed')
                ->with([                     
                        'email' => $this->mailData['email'],
                    ]);
        }
        //else
        //$this->mailData['mailFormat'] == markdown,view,text;
        $format =  isset($this->mailData['mailFormat']) ? 
                        $this->mailData['mailFormat'] : 
                        'view';
        //set format files accordingly
        return $this->markdown('mails.user-subscribed')
                ->with([                     
                        'email' => $this->mailData['email'],
                    ]);
        // return $this->from('example@example.com')
        //         ->view('mails.user-subscribed');

        //plain text
        // return $this->view('emails.orders.shipped')
        //         ->text('emails.orders.shipped_plain')

        //markdown
        // return $this->from('example@example.com')
        //         ->markdown('emails.orders.shipped');
    }
}
