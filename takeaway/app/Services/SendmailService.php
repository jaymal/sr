<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Events\ValidEmailRequestRecieved;
use App\Rules\MailableExist;
use App\Traits\LogSendStatus;

/**
 * 
 */
class SendmailService
{
	use LogSendStatus;
	
	function sendMail($data)
	{
        
		$this->validateSendmailRequest($data);

		$logged = $this->logAction($data);
		$data['queued_id'] = $logged;

		$this->fireSendmailEvent($data);

	}

	function fireSendmailEvent($data)
	{
		event(new ValidEmailRequestRecieved($data));
	}

	function validateSendmailRequest($data)
	{
		$data  = (array)json_decode($data['payload']);

        $validator = Validator::make($data, [
		    'to' => 'required',		  
		    'email' => 'email|required',		  
		    'subject' => 'required',		  
		    'message_text' => 'required',		  
		    'token' => 'required',
		     'mailable' =>['required', new MailableExist],   			  		 
		])->validate();

	}


}