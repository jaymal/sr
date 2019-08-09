<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

use App\Services\SendmailService;
use App\Events\ValidEmailRequestRecieved;
use App\Listeners\SendRecievedValidEmail;
use App\Mail\UserSubscribed;

class SendEmailTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function can_not_send_mail_without_mailable()
    {
    	$this->withExceptionHandling();
   
    	try{
    		$removeItem='mailable';
    		$this->callMailService($addItem =[],$removeItem, $updateItem=[]);
    	}catch (ValidationException $e) {

    		$this->assertArrayHasKey('mailable', $e->validator->errors()->messages());
        }

    }
    /** @test */
    public function can_not_send_mail_without_valid_mailable()
    {
    	$this->withExceptionHandling();
   
    	try{
    		$updateItem=['mailable'=> 'Non-existing-mailable-file'];
    		$this->callMailService($addItem =[], '', $updateItem );
    	}catch (ValidationException $e) {

    		$this->assertArrayHasKey('mailable', $e->validator->errors()->messages());
        }
    }

    /** @test */
    public function can_not_send_mail_without_to_field()
    {
    	$this->withExceptionHandling();
   
    	try{
    		$removeItem='to';
    		$this->callMailService($addItem =[],$removeItem, $updateItem=[]);
    	}catch (ValidationException $e) {
    		$this->assertArrayHasKey('to', $e->validator->errors()->messages());
        }
    }

    /** @test */
    public function can_trigger_send_mail_event_with_valid_fields()
    {
    	Event::fake();
    	//TODO: add a function to create a mailable file
    	$this->callMailService($addItem =[],$removeItem='', $updateItem=[]);

	 	Event::assertDispatched(ValidEmailRequestRecieved::class);
	 

    }

    /** @test */
    public function can_send_mailables_with_valid_fields()
    {
    	//Event::fake();
	 	Mail::fake();

		$this->callMailService($addItem =[],$removeItem='', $updateItem=[]);

        //Mail::assertSent(UserSubscribed::class);
        Mail::assertQueued(UserSubscribed::class);
	 

    }

    /** @test */
    public function can_not_send_mail_without_any_requried_field()
    {
    	$this->withExceptionHandling();

    	$requiredFields = ['to','email', 'subject','token','mailable'];
    	
    	foreach ( $requiredFields as $key => $value) {
   
	    	try{

	    		$this->callMailService($addItem =[], $value, $updateItem=[]);

	    	}catch (ValidationException $e) {

	    		$this->assertArrayHasKey($value, $e->validator->errors()->messages());

	        }
    	}


    
    }

    public function callMailService($addItem =[], $removeItem, $updateItem=[])
    {
    	$service   =  new SendmailService;
    	$values = [
    		'to' => 'to@example.com', 	  
		    'email' => 'email@example.com',		  
		    'subject' => 'Subject',		  
		   // 'message_text' => 'message text',		  
		    'token' => 'token123',
		    'mailable' =>'UserSubscribed',
    		];

    	if(!empty($addItem)){
    		$values = array_merge($values, $addItem);
    	}

    	if(!empty($removeItem)){
    		unset($values[$removeItem]);
    	}

    	if(!empty($updateItem)){
    		$values = array_merge($values, $updateItem);
    	}

    	$service->sendMail($values);
    }
}
