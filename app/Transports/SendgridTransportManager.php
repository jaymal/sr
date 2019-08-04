<?php
 
namespace App\Transports;
 
use Illuminate\Mail\TransportManager;
 
class SendgridTransportManager extends TransportManager
{
	protected function createMailjetDriver()
	{
		return new SendgridTransport;
	}
}