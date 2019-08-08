<?php
 
namespace App\Transports;
 
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;
 
class SendgridTransport extends Transport
{

	protected $apiKey;

	 
	public function __construct()
	{
		$this->apiKey = env('SENDGRID_API_KEY');
	}
	 
	public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
	{
	 
		$this->beforeSendPerformed($message);

		$email = new \SendGrid\Mail\Mail();
		$email->setFrom(config('mail.from.address'), config('mail.from.name'));
		$email->setSubject($message->getSubject());
		$email->addTos($this->getTo($message));
		$email->addContent("text/plain", $message->getBody());
		$email->addContent(
		    "text/html",$message->getBody()
		);
		$sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
		$response = $sendgrid->send($email);

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
		return $this->allContacts($message);
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