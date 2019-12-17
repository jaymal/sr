<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConvertCurrencyTest extends TestCase
{
    
    /** @test */
    public function user_can_convert_currencies()
    {
        $this->withExceptionHandling();

        $amount = 100;
        $from = 'USD';
        $to   = 'QAR';

        $response = $this->json('GET', '/api/convert/'.$amount.'/'.$from.'/'.$to);
        $response->assertSee('QAR364');
        $response->assertStatus(200);
    }
}
