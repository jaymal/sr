<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Events\ValidEmailRequestRecieved;
use App\Rules\MailableExist;

/**
 * 
 */
class SendmailService
{
	
	function sendMail($data)
	{
		 /* echo "<pre>";
		  print_r($data);
		  exit;*/
         //$data = $this->sentData();
         //exit(print_r(json_decode($data['payload'])));
         $data  = (array)json_decode($data['payload']);
         

        $validator = Validator::make($data, [
		    'to' => 'required',		  
		    'email' => 'email|required',		  
		    'subject' => 'required',		  
		    'message_text' => 'required',		  
		    'token' => 'required',
		     'mailable' =>['required', new MailableExist],   			  		 
		])->validate();

        //create an event and queue the mail
        event(new ValidEmailRequestRecieved($data));
	}
}