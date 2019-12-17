<?php

namespace App\Traits;

trait ProvideApiKey
{
	public function getApiKey()
    {
        return env('APIKEY', '');
    }
}