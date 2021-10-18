#!/usr/bin/php
<?php
 require_once "loxberry_log.php";
 
 	class guntamatic_heater {
		public $status;
		public $program;
		public $kesseltemp;
		public $co2;
		public $leistung;
		public $pufferO;
		public $pufferU;
		public $aussentemp;
		public $warmwasser;
		public $pumpeHP0;
		public $asche;
		public $stoerung;
		
		public $vorlauf;
		
		function set_Status($n){
			$this->status = $n;
		}

		function set_Program($n){
			$this->program = $n;
		}

		function set_Kesseltemp($n){
			$this->kesseltemp = $n;
		}

		function set_Co2($n){
			$this->co2 = $n;
		}

		function set_Leistung($n){
			$this->leistung = $n;
		}

		function set_PufferO($n){
			$this->pufferO = $n;
		}

		function set_PufferU($n){
			$this->pufferU = $n;
		}

		function set_Aussentemp($n){
			$this->aussentemp = $n;
		}

		function set_Warmwasser($n){
			$this->warmwasser = $n;
		}
		
		function set_PumpeHP0($n){
			$this->pumpeHP0 = $n;
		}
		
		function set_Asche($n){
			$this->asche = $n;
		}

		function set_Stoerung($n){
			$this->stoerung = $n;
		}

		function set_Vorlauf($n){
			$this->vorlauf = $n;
		}
	}

	class guntamatic_api {
		protected $ip;
		protected $guntamtickey;
		protected $urlpath;
		protected $token;

		function set_auth($ip, $guntamtickey)
		{
			//LOGOK("set_auth start");
			$this->ip = $ip;
			$this->guntamtickey = $guntamtickey;
			$this->urlpath = "http://" . $ip ."/daqdata.cgi?key=" . $guntamtickey;
		}

		function logout()
		{
			return true;
		}
		
		function get_guntamatic()
		{
			//LOGOK("get_guntamatic start");
			$guntamatic = new guntamatic_heater();

			$result = $this->get_html();

			if ( $result == false )
			{
				LOGCRIT("Guntamatic URL not reachable, terminating");
				LOGEND("Processing terminated");
				return false;
			}
			else
			{
				if ($result->errors !== NULL) 
				{
					if ($result->errors[0]->code === "invalid.login") 
					{
						LOGCRIT("Wrong username ". $username . " or password " . $password . " for Guntamatic, terminating");
					}
					else 
					{
						LOGCRIT("Other Problem in getting access to Guntamatic, terminating");
					}
					LOGEND("Processing terminated");
					return false;
				}
				else 
				{
					LOGOK("Getting access to Guntamatic, successfull");   
				}

				if ($result == NULL) 
				{
					LOGCRIT("No data from Guntamatic, terminating");
					LOGEND("Processing terminated");
					return false;
				}
				else {
					LOGOK("Data from Guntamatic received");				
					//LOGOK("Data: ".$result);	
					$lines = explode("\n",$result);
					//LOGOK("after split");	
					//LOGOK(count($lines));	

					if (count($lines) >= 121) {
						//LOGOK("count($lines) > 84");	

						$guntamatic->set_Status($lines[0]);
						$guntamatic->set_Aussentemp($lines[1]);
						$guntamatic->set_Kesseltemp($lines[3]);
						$guntamatic->set_Leistung($lines[5]);
						$guntamatic->set_Co2($lines[8]);
						$guntamatic->set_PufferO($lines[17]);
						$guntamatic->set_PufferU($lines[19]);
						$guntamatic->set_PumpeHP0($lines[20]);
						$guntamatic->set_Warmwasser($lines[21]);
						
						$guntamatic->set_Vorlauf($lines[31]);
						
						$guntamatic->set_Program($lines[69]);
						
						$guntamatic->set_Stoerung($lines[80]);
						$guntamatic->set_Asche($lines[85]);
							
						// var parts_Guntamatic = $lines[68];
						// setState('Guntamatic_Kesselfreigabe_68', parts_Guntamatic, true);
					
						// var parts_Guntamatic = $lines[71];
						// setState('Guntamatic_Programm_HK1_71', parts_Guntamatic, true);
					
						// var parts_Guntamatic = $lines[79];
						// setState('Guntamatic_Stoer0_79', parts_Guntamatic, true);
					
						// var parts_Guntamatic = $lines[80];
						// setState('Guntamatic_Stoer1_80', parts_Guntamatic, true);
					
					
						// var parts_Guntamatic = $lines[89];
						// setState('Guntamatic_Brenstoffzähler_89', parts_Guntamatic, true);
					
						// var parts_Guntamatic = $lines[90];
						// setState('Guntamatic_Pufferladung_90', parts_Guntamatic, true);
					}
					else{
						LOGCRIT("Keine Daten empfangen");
					}
				}
			}	

			LOGOK("get_guntamatic finished");	
			return $guntamatic;
		}
		
		private function get_html()
		{
			$content = null;
			try {
				$ch = curl_init();
			
				// Check if initialization had gone wrong*    
				if ($ch === false) {
					LOGCRIT("failed to initialize");
				}
			
				// Better to explicitly set URL
				curl_setopt($ch, CURLOPT_URL, $this->urlpath);
				// That needs to be set; content will spill to STDOUT otherwise
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// Set more options
				//curl_setopt(/* ... */);
				
				//LOGCRIT($this->urlpath);
					
				$content = curl_exec($ch);
			
				// Check the return value of curl_exec(), too
				if ($content === false) {
					LOGCRIT("curlerror: ".curl_error($ch) . "Curlerrno:". curl_errno($ch));
				}
			
				// Check HTTP return code, too; might be something else than 200
				$httpReturnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($httpReturnCode != 200)
					LOGCRIT("httpReturnCode: ".$httpReturnCode);
				/* Process $content here */
			
			} catch(Exception $e) {
			
				LOGCRIT("Curl failed with error #%d: %s");
				// LOGCRIT(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
			
			} finally {
				// Close curl handle unless it failed to initialize
				if (is_resource($ch)) {
					curl_close($ch);
				}
			}

			return $content;
		}
		
		function control($mover_id, $command)
		{
			// switch ($command)
			// {
				// case 'park' :
				// case 'pause':
				// case 'start': 					return $this->get_html("mowers/".$mover_id."/control/".$command, array("period" => 180));
												// break;
				// case 'start3h':					return $this->get_html("mowers/".$mover_id."/control/start/override/period", array("period" => 180));
												// break;
				// case 'start6h':					return $this->get_html("mowers/".$mover_id."/control/start/override/period", array("period" => 360));
												// break;
				// case 'start12h':				return $this->get_html("mowers/".$mover_id."/control/start/override/period", array("period" => 720));
												// break;
				// case 'parkuntilnextschedule':	return $this->get_html("mowers/".$mover_id."/control/park/duration/timer", array("period" => 0));
												// break;
				// case 'park3h':					return $this->get_html("mowers/".$mover_id."/control/park/duration/timer", array("period" => 180));
												// break;
				// case 'park6h':					return $this->get_html("mowers/".$mover_id."/control/park/duration/timer", array("period" => 360));
												// break;
				// case 'park12h':	
					
			//	}
		}
	}
?>