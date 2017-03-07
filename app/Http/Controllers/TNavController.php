<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Parser;

class TNavController extends Controller
{
    public function index()
    {
        $url = 'http://mmdatraffic.interaksyon.com/livefeed/';
    	$str = file_get_contents($url);
		$parsed = Parser::xml($str);
		$feed = [];
		if(count($parsed)>0){
			$feed = $parsed['channel']['item'];
		}
		dd($feed);
    }
}
