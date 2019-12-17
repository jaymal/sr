<?php
 
namespace App\Transports;
 
use Illuminate\Mail\TransportManager;
 
class MailjetTransportManager extends TransportManager
{
	protected function createMailjetDriver()
	{
		return new MailjetTransport;
	}
}