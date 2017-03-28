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
			TNav::truncate();
			for($i=0; $i<count($feed); $i++){
				$tnav_entry = new TNav;
				$road = explode('-', $feed[$i]['title']);
				$road1 = str_replace('_', ' ', $road[0]);
				$road2 = str_replace('_', ' ', $road[1]);
				$tnav_entry->road1 = $road1;
				$tnav_entry->road2 = $road2;
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

    public function getUpdate($r){
    	$route = TNav::where('road1', $r)->groupBy('road2', 'way')->get();
    	$result = "MMDA TRAFFIC AT ".strtoupper($r).'<br/><br/>';
    	foreach($route as $r){
    		$result .= strtoupper($r->road2).' ';
    		$result .= ($r->way=="SB")? "SOUTHBOUND" : "NORTHBOUND";
    		$result .= " as of ".$r->pubDate.": <br/>";
    		$result .= ($r->description=="L")? "Light Traffic" : (($r->description=="ML")? "Moderate Traffic" : "Heavy Traffic");
    		$result .= "<br/><br/>";
    	}
    	return $result;
    }

    public function getTrafficUpdate($r){
    	$route = TNav::where('road2', $r)->groupBy('road2', 'way')->get();
    	$result = "MMDA TRAFFIC AT ".strtoupper($r).'<br/><br/>';
    	foreach($route as $r){
    		$result .= strtoupper($r->road2).' ';
    		$result .= ($r->way=="SB")? "SOUTHBOUND" : "NORTHBOUND";
    		$result .= " as of ".$r->pubDate.": <br/>";
    		$result .= ($r->description=="L")? "Light Traffic" : (($r->description=="ML")? "Moderate Traffic" : "Heavy Traffic");
    		$result .= "<br/><br/>";
    	}
    	return $result;
    }
}
