<?php

namespace App\Providers;

use App\Providers\ValidEmailRequestRecieved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReceievedValidEmai
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ValidEmailRequestRecieved  $event
     * @return void
     */
    public function handle(ValidEmailRequestRecieved $event)
    {
        //
    }
}
