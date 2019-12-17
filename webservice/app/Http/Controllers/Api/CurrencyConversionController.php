<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ConvertCurrencyService;
use Illuminate\Support\Facades\Validator;


class CurrencyConversionController extends Controller
{

    public $convertCurrencyService;

    public function __construct(ConvertCurrencyService $convertCurrencyService)
    {
        $this->convertCurrencyService = $convertCurrencyService;
    }


     /**
     * display the list of all currencies
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       $currencies =  $this->convertCurrencyService->listCurrency();
       return response()->json(['data' => $currencies, 'message'=>'currencies retrieved', 'success' => 1], 200);

    }

    /**
     * Show the currency conversion of 
     * Amount to be converted is $value from currency $from to $to
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $value, $from, $to)
    {
        
       $convertedAmount =  $this->convertCurrencyService->getConvertedAmountandCurrency($value, $from, $to);
       return response()->json(['data' => $convertedAmount, 'message'=>'currency converted', 'success' => 1], 200);

    }
   
}
