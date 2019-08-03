<?php

namespace App\Traits;

use App\Models\Email_log;

trait UpdateSendStatus
{
	public function logAction($payload, $status='Queued')
	{
		/*$record = [
            'email' => 			$data['email'],
            'status' => 		$status,
            'service_used' =>  	$data['service_used'],
            'mailable' =>  		$data['mailable'],
        ]
        if($status !== 'Queued'){
        	$record['updated_at'] = date("Y-m-d");
        }
		return Email_log::create($record);*/

		return $status;
	}
}