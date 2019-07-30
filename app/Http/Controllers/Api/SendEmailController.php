<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UpdateSendStatus;
use Illuminate\Support\Facades\Validator;


use App\Events\ValidEmailRequestRecieved;
use App\Rules\MailableExist;

//use App\Http\Resources\MessageResource;

class SendEmailController extends Controller
{
    use UpdateSendStatus;

    public function create(Request $request)
    {

        //json_decode request
        //check if valid token
        //pass the request to event
        //queue up the mails and send
         $data = $request->all();
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

        /*if ($validator->fails()) {
		    exit("validator failed");
		}*/
        //create an event and queue the mail
        event(new ValidEmailRequestRecieved($data));

        //log mail queued
      	$queued =  $this->setSendStatus($data, "queued");


        return response()->json(['message'=>$queued ],200);
        
    }
   
    public function sentData()
    {
    	//Mock sender data
		$data = array(
			'to' => 'John Doe',
			'email' => 'doe@example.com',
			'subject' => 'Hello John- food is ready',
			'message_text'=> 'Dear John, You Are The Best!',
			'mailable' => 'UserSubscribed',
		);
		//Add Token To Check
		$data['token'] = 'ABC123-NotRealToken';
		//JSON encode the message
		$message = json_encode($data);
		echo "<pre>";
		print_r($message);
		exit;
		/*echo $message;*/

	return ['payload' => $message];
	}


}
