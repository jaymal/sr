<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\ConvertCurrencyService;

class CurrencyConversionTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_get_conversion_rate()
    {
    	$service   =  new ConvertCurrencyService;
    	$from = 'USD';
    	$to   = 'QAR';
    	$expected = 3.64;
    	$actual = number_format($service->getRate($from, $to), 2, '.', '');
    	$this->assertEquals($expected, $actual);
    	//$this-assertEquals()
    }

    /** @test */
    public function can_get_converted_amount()
    {	
    	$service   =  new ConvertCurrencyService;
    	$amount = 100;
    	$from = 'USD';
    	$to   = 'QAR';
    	$expected = 364.08;
    	$actual = $service->convertCurrency($amount, $from, $to);
    	$this->assertEquals($expected, $actual);
    	
    }

    /** @test */
    public function can_get_converted_amount_and_currency()
    {	
    	$service   =  new ConvertCurrencyService;
    	$amount = 100;
    	$from = 'USD';
    	$to   = 'QAR';
    	$expected = 'QAR364.08';
    	$actual = $service->getConvertedAmountandCurrency($amount, $from, $to);
    	$this->assertEquals($expected, $actual);
    	
    }
    
}
