<?php

namespace App\Mailer;

/**
 * Custom implementation of mailer
 */
class TakeawayMailer extends \Illuminate\Mail\Mailer
{
	
	public function send($view, array $data = [], $callback = null)
    {
        // Do any custom checks
    	 //\Log::info('Custom mailer',['mailer used'=> 'TakeawayMailer']);
        return parent::send($view, $data, $callback);
    }
}