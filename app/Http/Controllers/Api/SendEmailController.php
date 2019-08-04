<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UpdateSendStatus;
use App\Services\SendmailService;
use Illuminate\Support\Facades\Validator;


use App\Events\ValidEmailRequestRecieved;
use App\Rules\MailableExist;


//use App\Http\Resources\MessageResource;

class SendEmailController extends Controller
{
    use UpdateSendStatus;
    public $sendmailService;
    public function __construct(SendmailService $sendmailService)
    {
    	$this->sendmailService = $sendmailService;
    }

    public function create(Request $request)
    {

        //json_decode request
        //check if valid token
        //pass the request to event
        //queue up the mails and send
        $data = $request->all();

		$this->sendmailService->sendMail($data);
        //log mail queued
      	$queued =  $this->logAction($data, "queued");


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
