<?php 

namespace App\Services;

use App\Traits\ProvideApiKey;

use GuzzleHttp\Client;


class ConvertCurrencyService
{
	
	use ProvideApiKey;


	/**
     * converts and return the converted amount
     *
     * 
     */
	function convertCurrency($amount, $from, $to) :string
	{
    		
		//$toCurrency = urlencode($to);
		
		$rate = $this->getRate($from, $to);

        $converted = $rate * $amount;

		$value =  number_format($converted, 2, '.', '');
		
		return $value;

	}

	/**
     * return the converted amount along with currency
     *
     * 
     */
	function getConvertedAmountandCurrency($amount, $from, $to) :string
	{
    		
		$convertedAmount = $this->convertCurrency($amount, $from, $to);
		
		$toCurrency = urlencode($to);
		
		return $toCurrency.$convertedAmount;

	}

	/**
     * makes api call to get the currency conversion rate
     * 
     *
     * @return \Illuminate\Http\Response
     */
	public function getRate($from, $to): string
	{
		$http = new Client;

		$apiKey = $this->getApiKey(); 

		$fromCurrency = urlencode($from);
		$toCurrency = urlencode($to);
		$query =  "{$fromCurrency}_{$toCurrency}";

        $response = $http->get("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apiKey}");

        $responseArray = json_decode((string)$response->getBody(), true);

        return $responseArray[$query];

	}
	/**
     * make api call to list all currencies
     * 
     *
     * @return \Illuminate\Http\Response
     */
	function listCurrency(): string
	{
        
		$http = new Client;
		$apiKey = $this->getApiKey();
        $response = $http->get("https://free.currconv.com/api/v7/currencies?apiKey={$apiKey}");
        $responseArray = json_decode((string)$response->getBody(), true);
        $currencies =  array_keys($responseArray['results']);
        asort($currencies);
        return json_encode($currencies);
	}

}