<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConversionLog;

use GuzzleHttp\Client;

class HomeController extends Controller
{
    //
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return ConversionLog::orderBy('id', 'desc')->take(20)->get()->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$http = new Client;
        $response = $http->get("http://webserver:80/api/currencies");

    	$responseArray = json_decode((string)$response->getBody(), true);
    	$currencies = json_decode($responseArray['data']);
        $apiBaseUrl = env('DOCKER_BASE_IP','http://192.168.99.100');
        
    	return view('welcome', compact('currencies', 'apiBaseUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBusinessLoan  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		return ConversionLog::create([
			'amount'=> $request->amount,
			'to_currency'=> $request->to_currency,
			'from_currency'=> $request->from_currency,
			'converted'=> $request->converted
		]);
    	
    }
}
