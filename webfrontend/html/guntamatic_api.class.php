<?php
 require_once "loxberry_log.php";
 
class husqvarna_api {

	protected $url_api_im = 'https://iam-api.dss.husqvarnagroup.net/api/v3/';
	protected $url_api_track = 'https://amc-api.dss.husqvarnagroup.net/app/v1/';
	protected $ip;
	protected $guntamtickey;
	protected $token;
	protected $provider;



    function set_auth($ip, $guntamtickey)
	{
        LOGDEB("Calling Auth to Husqvarna API");	
		
        $this->ip = $ip;
        $this->guntamtickey = $guntamtickey;
	}

    function logout()
	{
		return true;
	}
	
	function get_guntamatic()
	{
		$guntamatic = new guntamatic_heater();
		
		var request= require('request');
		request.post({
		  url:     'http://'+ $ip+ '/daqdata.cgi?key='+&guntamtickey
		}, function(error, response, body){
		  if (body) {
			  
			  var lines = body.split('\n');
			  $guntamatic->status = lines[0];
			  $guntamatic->aussentemp = lines[1];
			  $guntamatic->kesseltemp = lines[3];
			  $guntamatic->leistung = lines[5];
			  $guntamatic->co2 = lines[8];
			  $guntamatic->pufferO = lines[17];
			  $guntamatic->pufferU = lines[19];
			  $guntamatic->pumpeHP0 = = lines[20];
			  $guntamatic->warmwasser  = lines[21];
			  
			  $guntamatic->vorlauf = lines[31];
			  
			  $guntamatic->program = lines[69];
			  
			  $guntamatic->stoerung = lines[80];
			  $guntamatic->asche = lines[85];
		 		 
			  // var parts_Guntamatic = lines[68];
			  // setState('Guntamatic_Kesselfreigabe_68', parts_Guntamatic, true);
		 
			  // var parts_Guntamatic = lines[71];
			  // setState('Guntamatic_Programm_HK1_71', parts_Guntamatic, true);
		 
			  // var parts_Guntamatic = lines[79];
			  // setState('Guntamatic_Stoer0_79', parts_Guntamatic, true);
		 
			  // var parts_Guntamatic = lines[80];
			  // setState('Guntamatic_Stoer1_80', parts_Guntamatic, true);
		 
		 
			  // var parts_Guntamatic = lines[89];
			  // setState('Guntamatic_Brenstoffzähler_89', parts_Guntamatic, true);
		 
			  // var parts_Guntamatic = lines[90];
			  // setState('Guntamatic_Pufferladung_90', parts_Guntamatic, true);
		  }
		 
		 
		if (getState("Guntamatic_Leistung_5").val == 0)
		{
			setState("Guntamatic_CO2_Gehalt_korrigiert" , 0, true);
		}
		else
		{
			setState("Guntamatic_CO2_Gehalt_korrigiert",getState("Guntamatic_CO2_Gehalt_8").val);  
		}
		 
		 
		}); 
		
		return $guntamatic;
	}
	
	function control($mover_id, $command)
	{
		switch ($command)
		{
			case 'park' :
			case 'pause':
			case 'start': 					return $this->get_api("mowers/".$mover_id."/control/".$command, array("period" => 180));
			              					break;
			case 'start3h':					return $this->get_api("mowers/".$mover_id."/control/start/override/period", array("period" => 180));
			              					break;
			case 'start6h':					return $this->get_api("mowers/".$mover_id."/control/start/override/period", array("period" => 360));
			              					break;
			case 'start12h':				return $this->get_api("mowers/".$mover_id."/control/start/override/period", array("period" => 720));
			              					break;
			case 'parkuntilnextschedule':	return $this->get_api("mowers/".$mover_id."/control/park/duration/timer", array("period" => 0));
			              					break;
			case 'park3h':					return $this->get_api("mowers/".$mover_id."/control/park/duration/timer", array("period" => 180));
											break;
			case 'park6h':					return $this->get_api("mowers/".$mover_id."/control/park/duration/timer", array("period" => 360));
											break;
			case 'park12h':					return $this->get_api("mowers/".$mover_id."/control/park/duration/timer", array("period" => 720));
		}
	}
	
	function settings($mover_id, $data = null)
	{
		$result = $this->get_api("mowers/".$mover_id."/settings", array("settings" => $data), true);
		if ($result==NULL) $result->status = "OK";
		return $result;
	}
}
?> 