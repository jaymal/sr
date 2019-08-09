<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SendmailService;
use Illuminate\Support\Facades\Validator;

use App\Events\ValidEmailRequestRecieved;
use App\Rules\MailableExist;


class SendEmailController extends Controller
{

    public $sendmailService;

    public function __construct(SendmailService $sendmailService)
    {
        $this->sendmailService = $sendmailService;
    }

    public function create(Request $request)
    {
       
        $data = $request->all();
        
        $this->sendmailService->sendmail($data);
	
        return response()->json(['message'=>'Queued' ],200);
        
    }

    public function show()
    {
        header('Access-Control-Allow-Origin: *'); 
        $emailLog = $this->sendmailService->getEmailLog();
        return response()->json($emailLog ,200);
        //return json_encode($d['Sent', 'Queued', 'Removed', 'Failed']);
    }
   
}
