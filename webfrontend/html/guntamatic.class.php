<?php
 require_once "loxberry_log.php";
 
class husqvarna_api {

	protected $url_api_im = 'https://iam-api.dss.husqvarnagroup.net/api/v3/';
	protected $url_api_track = 'https://amc-api.dss.husqvarnagroup.net/app/v1/';
	protected $ip;
	protected $guntamtickey;
	protected $token;
	protected $provider;
	
	var $automoweractivity= array (
			  	"UNKNOWN" 				=>0,  // Unbekannt
				"NOT_APPLICABLE" 		=>1,  // ??
				"MOWING" 				=>2,  // M�hen
				"GOING_HOME" 			=>3,  // F�hrt zur�ck zur Ladestation
				"CHARGING"				=>4,  // Laden
				"LEAVING"				=>5,  // Verl�sst Ladestation
				"PARKED_IN_CS"			=>6   // Geparkt in der Latestation
				);
				
	var $automowerstate= array (
			  	"UNKNOWN" 				=>0,  // 
				"NOT_APPLICABLE" 		=>1,  // 
				"PAUSED" 				=>2,  // 
				"IN_OPERATION" 			=>3,  //
				"WAIT_UPDATING"			=>4,  //
				"WAIT_POWER_UP"			=>5,  //
				"RESTRICTED"			=>6,  //
				"OFF" 					=>7,  //
				"STOPPED"				=>8,  //
				"ERROR"					=>10, //
				"FATAL_ERROR"			=>10, //
				"ERROR_AT_POWER_UP"		=>10  //
				);


    function login($ip, $guntamtickey)
	{
		
        LOGDEB("Calling Logon to Husqvarna API");	
		
        $this->ip = $ip;
        $this->guntamtickey = $guntamtickey;
		$fields["data"]["attributes"]["ip"] = $this->ip;
		$fields["data"]["attributes"]["guntamtickey"] = $this->guntamtickey;
		$fields["data"]["type"] = "token";
		
		$result = $this->post_api("token", $fields);
		//LOGOK("Data received from Husqvarna Connect API:".json_encode($result));
		if ( $result == false )
	 	{
	        LOGCRIT("Husqvarna URL not reachable, terminating");
	        LOGEND("Processing terminated");
	        return false;
		}
		else
		{
			if ($result->errors !== NULL) 
			{
				if ($result->errors[0]->code === "invalid.login") 
				{
					LOGCRIT("Wrong ip ". $ip . " or key " . $guntamtickey . " for Husqvarna Connect API, terminating");
				}
			    else 
				{
			    	LOGCRIT("Other Problem in getting access to Husqvarna Connect API, terminating");
				}
				LOGEND("Processing terminated");
				return false;
			}
			else 
			{
				LOGOK("Getting access to Husqvarna Connect API, successfull");   
			}
			if ($result == NULL) 
			{
				LOGCRIT("No data from Husqvarna Connect API, terminating");
				LOGEND("Processing terminated");
				return false;
			}
			else {
				LOGOK("Data from Husqvarna Connect API received");
			}
			
			$this->token = $result->data->id;
			$this->provider = $result->data->attributes->provider;
			return true;
		}
		
	}

	private function get_headers($fields = null)
	{
		if ( isset($this->token) )
		{
			$generique_headers = array(
			   'Content-type: application/json',
			   'Accept: application/json',
				'Authorization: Bearer '.$this->token,
				'Authorization-Provider: '.$this->provider
			);
		}
		else
		{
			$generique_headers = array(
			   'Content-type: application/json',
			   'Accept: application/json'
			   );
		}
		if ( isset($fields) )
		{
			$custom_headers = array('Content-Length: '.strlen(json_encode ($fields)));
		}
		else
		{
			$custom_headers = array();
		}
		return array_merge($generique_headers, $custom_headers);
	}

	private function post_api($page, $fields = null)
	{
		$session = curl_init();

		curl_setopt($session, CURLOPT_URL, $this->url_api_im . $page);
		curl_setopt($session, CURLOPT_HTTPHEADER, $this->get_headers($fields));
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		if ( isset($fields) )
		{
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode ($fields));
		}
		$json = curl_exec($session);
		curl_close($session);
        return json_decode($json);
	}

	private function get_api($page, $fields = null, $put = null)
	{
		$session = curl_init();

		curl_setopt($session, CURLOPT_URL, $this->url_api_track . $page);
		if ( isset($put) ){ if ($put == true) curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'PUT');}
		curl_setopt($session, CURLOPT_HTTPHEADER, $this->get_headers($fields));
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		if ( isset($fields) )
		{
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($fields));
		}
		$json = curl_exec($session);
		curl_close($session);
		return json_decode($json);
	}

	private function del_api($page)
	{
		$session = curl_init();

		curl_setopt($session, CURLOPT_URL, $this->url_api_im . $page);
		curl_setopt($session, CURLOPT_HTTPHEADER, $this->get_headers());
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($session);
		curl_close($session);
//		throw new Exception(__('La livebox ne repond pas a la demande de cookie.', __FILE__));
		return json_decode($json);
	}

    function logout()
	{
		$result = $this->del_api("token/".$this->token);
		if ( $result !== false )
		{
			unset($this->token);
			unset($this->provider);
			return true;
		}
		return false;
	}
	
	function list_robots()
	{
		$list_robot = array();
		foreach ($this->get_api("mowers") as $robot)
		{
			$list_robot[$robot->id] = $robot;
		}
		return $list_robot;
	}
	
	function get_robot()
	{
		return $this->get_api("mowers");
	}

	function get_status($mover_id)
	{
		
		return $this->get_api("mowers/".$mover_id."/status");
	}

	function get_geofence($mover_id)
	{
		
		return $this->get_api("mowers/".$mover_id."/geofence");
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
?>