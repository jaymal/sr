<?php
 
namespace App\Transports;
 
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;
 
class MailjetTransport extends Transport
{

	protected $publicKey;
	protected $secretKey;
	 
	public function __construct()
	{
		$this->publicKey = env('MAIlJET_APIKEY_PUBLIC');
		$this->secretKey = env('MAIlJET_APIKEY_PRIVATE');
	}
	 
	public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
	{
	 
		$this->beforeSendPerformed($message);
		 
		$mj = new \Mailjet\Client($this->publicKey, $this->secretKey,
		true,['version' => 'v3.1']);
		 
		$response = $mj->post(\Mailjet\Resources::$Email, ['body' => $this->getBody($message)]);
		 
		$this->sendPerformed($message);
		 
		return $this->numberOfRecipients($message);
	}
	 
	/**
	* Get body for the message.
	*
	* @param \Swift_Mime_SimpleMessage $message
	* @return array
	*/
	 
	protected function getBody(Swift_Mime_SimpleMessage $message)
	{
	return [
		'Messages' => [
			[
				'From' => [
					'Email' => config('mail.from.address'),
					'Name' => config('mail.from.name')
				],
				'To' => $this->getTo($message),
				'Subject' => $message->getSubject(),
				'HTMLPart' => $message->getBody(),
				]
			]
		];
	}
	 
	/**
	* Get the "to" payload field for the API request.
	*
	* @param \Swift_Mime_SimpleMessage $message
	* @return string
	*/
	protected function getTo(Swift_Mime_SimpleMessage $message)
	{
		return collect($this->allContacts($message))->map(function ($display, $address) {
		return $display ? [
			'Email' => $address,
			'Name' =>$display
		] : [
			'Email' => $address,
		];
		 
		})->values()->toArray();
	}
	 
	/**
	* Get all of the contacts for the message.
	*
	* @param \Swift_Mime_SimpleMessage $message
	* @return array
	*/
	protected function allContacts(Swift_Mime_SimpleMessage $message)
	{
		return array_merge(
		(array) $message->getTo(), (array) $message->getCc(), (array) $message->getBcc()
		);
	}




}