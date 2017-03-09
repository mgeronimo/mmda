<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Parser;
use App\TNav;

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
			for($i=0; $i<count($feed); $i++){
				$tnav_entry = new TNav;
				$road = explode('-', $feed[$i]['title']);
				$tnav_entry->road1 = $road[0];
				$tnav_entry->road2 = $road[1];
				$tnav_entry->way = $road[count($road)-1];
				$tnav_entry->description = $feed[$i]['description'];
				$tnav_entry->pubDate = $feed[$i]['pubDate'];
				$tnav_entry->save();
			}
			echo 'Success, besh';
		}
		else{
			echo 'Parsing failed';
		}
    }
}
