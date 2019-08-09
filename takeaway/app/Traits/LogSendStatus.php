<?php

namespace App\Traits;

use App\Models\Email_log;

trait LogSendStatus
{
	public function logAction($payload, $status='Queued')
	{

        $record = [
            'email' => 			$payload['email'],
            'status' => 		$status,
            'mailable' =>  		$payload['mailable'],
        ];
        if($status !== 'Queued'){
        	$record['updated_at'] = date("Y-m-d");
        }
		$logged =  Email_log::create($record);
        
        return $logged->id;

	}

    public function updateLogStatus($payload, $status)
    {
        return  Email_log::find($payload['queued_id'])->update([
            'status' => $status, 'updated_at' => date("Y-m-d")
        ]);

    }
}