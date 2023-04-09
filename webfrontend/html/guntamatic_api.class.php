#!/usr/bin/php
<?php
 require_once "loxberry_log.php";
 
 	class guntamatic_heater {
		public $betrieb;
		public $program;
		public $kesseltemp;
		public $co2;
		public $leistung;
		public $pufferO;
		public $pufferU;
		public $aussentemp;

		public $programHK0;
		public $programHK1;
		public $programHK2;
		public $programHK3;
		public $programHK4;
		public $programHK5;
		public $programHK6;
		public $programHK7;
		public $programHK8;
		
		public $pumpeHP0;

		public $warmwassertemp;
		public $warmwassertemp1;
		public $warmwassertemp2;
		public $pumpeWasser;
		public $pumpeWasser1;
		public $pumpeWasser2;

		public $raumTempHk0;
		public $raumTempHk1;
		public $raumTempHk2;
		public $raumTempHk3;
		public $raumTempHk4;
		public $raumTempHk5;
		public $raumTempHk6;
		public $raumTempHk7;
		public $raumTempHk8;

		public $pumpeHk0;
		public $pumpeHk1;
		public $pumpeHk2;
		public $pumpeHk3;
		public $pumpeHk4;
		public $pumpeHk5;
		public $pumpeHk6;
		public $pumpeHk7;
		public $pumpeHk8;

		public $asche;
		public $stoerung;
		public $stoerung2;
		public $rauchgasauslastung;
		public $saugzuggeblaese;
		public $stokerProzent;
		
		public $vorlauf;
		public $vorlaufHK1;
		public $vorlaufHK2;
		public $vorlaufHK3;
		public $vorlaufHK4;
		public $vorlaufHK5;
		public $vorlaufHK6;
		public $vorlaufHK7;
		public $vorlaufHK8;

		public $brandschutzklappe;
		public $fuellstand;
		public $stb;
		public $tks1;
		public $kesselfreigabe;
		
		function Get_ArrayResult(){
			$result = array ("betrieb" => $this->betrieb, 
							"program" => $this->program,
							"kesseltemp" => $this->kesseltemp, 
							"co2" => $this->co2, 
							"leistung" => $this->leistung,
							"pufferO" => $this->pufferO, 
							"pufferU" => $this->pufferU, 
							"aussentemp" => $this->aussentemp, 
							"programHK0" => $this->programHK0,
							"programHK1" => $this->programHK1,
							"programHK2" => $this->programHK2,
							"programHK3" => $this->programHK3,
							"programHK4" => $this->programHK4,
							"programHK5" => $this->programHK5,
							"programHK6" => $this->programHK6,
							"programHK7" => $this->programHK7,
							"programHK8" => $this->programHK8,
							"pumpeHP0" => $this->pumpeHP0,
							"warmwassertemp" => $this->warmwassertemp,
						    "warmwassertemp1" => $this->warmwassertemp1,
						    "warmwassertemp2" => $this->warmwassertemp2,
						    "pumpeWasser" => $this->pumpeWasser,
						    "pumpeWasser1" => $this->pumpeWasser1,
						    "pumpeWasser2" => $this->pumpeWasser2,
							"raumTempHk0" => $this->raumTempHk0,
							"raumTempHk1" => $this->raumTempHk1,
							"raumTempHk2" => $this->raumTempHk2,
							"raumTempHk3" => $this->raumTempHk3,
							"raumTempHk4" => $this->raumTempHk4,
							"raumTempHk5" => $this->raumTempHk5,
							"raumTempHk6" => $this->raumTempHk6,
							"raumTempHk7" => $this->raumTempHk7,
							"raumTempHk8" => $this->raumTempHk8,
							"pumpeHk0" => $this->pumpeHk0,
							"pumpeHk1" => $this->pumpeHk1,
							"pumpeHk2" => $this->pumpeHk2,
							"pumpeHk3" => $this->pumpeHk3,
							"pumpeHk4" => $this->pumpeHk4,
							"pumpeHk5" => $this->pumpeHk5,
							"pumpeHk6" => $this->pumpeHk6,
							"pumpeHk7" => $this->pumpeHk7,
							"pumpeHk8" => $this->pumpeHk8,
							"asche" => $this->asche,
							"stoerung" => $this->stoerung,
							"stoerung2" => $this->stoerung2,
							"rauchgasauslastung" => $this->rauchgasauslastung,
							"saugzuggeblaese" => $this->saugzuggeblaese,
							"stokerProzent" => $this->stokerProzent,
							"vorlauf" => $this->vorlauf,
							"vorlaufHK1" => $this->vorlaufHK1,
							"vorlaufHK2" => $this->vorlaufHK2,
							"vorlaufHK3" => $this->vorlaufHK3,
							"vorlaufHK4" => $this->vorlaufHK4,
							"vorlaufHK5" => $this->vorlaufHK5,
							"vorlaufHK6" => $this->vorlaufHK6,
							"vorlaufHK7" => $this->vorlaufHK7,
							"vorlaufHK8" => $this->vorlaufHK8,
							"brandschutzklappe" => $this->brandschutzklappe,
							"fuellstand" => $this->fuellstand,
							"stb" => $this->stb,
							"tks1" => $this->tks1,
							"kesselfreigabe" => $this->kesselfreigabe);
			return $result;
		}

		function Get_EinAusToInt($n){
			if ($n != NULL ){
				if ($n == "EIN"){
					return 1;
				}
			}
			return 0;
		}

		function Get_Program($n){
			if ($n != NULL){
				if ( $n == "AUS"){
					return 0;}
				if ( $n == "NORMAL"){
					return 1;}
				if ($n == "HEIZEN"){
					return 2;}
				if ($n == "STOKERENTL."){
					return 3;}
			}
			return -1;
		}

		function Get_Float($n){
			if ($n != NULL){
				return (float)$n;
				// return floatval($n);
			}

			return 0;
		}

		function set_Betrieb($n){

			if ($n != NULL){
				if ($n == "AUS"){
					$this->betrieb = 0;}	
				if ($n == "EIN"){
					$this->betrieb = 1;}	
				if ($n == "REGELUNG"){
					$this->betrieb = 2;}
				if( $n == "NACHLAUF"){
					$this->betrieb = 3;}
				if( $n == "ZÜNDUNG"){
					$this->betrieb = 4;}
				if( $n == "START"){
					$this->betrieb = 5;}
			}
			else{
			$this->betrieb = -1;}
		}
		function set_Program($n){
			$this->program = $this->Get_Program($n);
		}
		function set_ProgramHK0($n){
			$this->programHK0 = $this->Get_Program($n);
		}
		function set_ProgramHK1($n){
			$this->programHK1 = $this->Get_Program($n);
		}
		function set_ProgramHK2($n){
			$this->programHK2 = $this->Get_Program($n);
		}
		function set_ProgramHK3($n){
			$this->programHK3 = $this->Get_Program($n);
		}
		function set_ProgramHK4($n){
			$this->programHK4 = $this->Get_Program($n);
		}
		function set_ProgramHK5($n){
			$this->programHK5 = $this->Get_Program($n);
		}
		function set_ProgramHK6($n){
			$this->programHK6 = $this->Get_Program($n);
		}
		function set_ProgramHK7($n){
			$this->programHK7 = $this->Get_Program($n);
		}
		function set_ProgramHK8($n){
			$this->programHK8 = $this->Get_Program($n);
		}
		function set_Kesseltemp($n){
			$this->kesseltemp = $this->get_float($n);
		}
		function set_Co2($n){
			$this->co2 = $this->get_float($n);
		}
		function set_Leistung($n){
			$this->leistung = $this->get_float($n);
		}
		function set_PufferO($n){
			$this->pufferO = $this->get_float($n);
		}
		function set_PufferU($n){
			$this->pufferU = $this->get_float($n);
		}
		function set_Aussentemp($n){
			$this->aussentemp = $this->get_float($n);
		}
		function set_WarmwasserTemp($n){
			$this->warmwassertemp = $this->get_float($n);
		}
		function set_WarmwasserTemp1($n){
			$this->warmwassertemp1 = $this->get_float($n);
		}
		function set_WarmwasserTemp2($n){
			$this->warmwassertemp2 = $this->get_float($n);
		}
		function set_PumpeWarmwasser($n){
			$this->pumpeWasser = $this->Get_EinAusToInt($n);
		}
		function set_PumpeWarmwasser1($n){
			$this->pumpeWasser1 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeWarmwasser2($n){
			$this->pumpeWasser2= $this->Get_EinAusToInt($n);
		}
		function set_PumpeHP0($n){
			$this->pumpeHP0 = $this->Get_EinAusToInt($n);
		}
		function set_Asche($n){
			$this->asche = $this->get_float($n);
		}
		function set_Stoerung($n){
			$this->stoerung = $n;
		}
		function set_Stoerung2($n){
			$this->stoerung2 = $n;
		}
		function set_Vorlauf($n){
			$this->vorlauf = $this->get_float($n);
		}
		function set_VorlaufHK1($n){
			$this->vorlaufHK1 = $this->get_float($n);
		}
		function set_VorlaufHK2($n){
			$this->vorlaufHK2 = $this->get_float($n);
		}
		function set_VorlaufHK3($n){
			$this->vorlaufHK3 = $this->get_float($n);
		}
		function set_VorlaufHK4($n){
			$this->vorlaufHK4 = $this->get_float($n);
		}
		function set_VorlaufHK5($n){
			$this->vorlaufHK5 = $this->get_float($n);
		}
		function set_VorlaufHK6($n){
			$this->vorlaufHK6 = $this->get_float($n);
		}
		function set_VorlaufHK7($n){
			$this->vorlaufHK7 = $this->get_float($n);
		}
		function set_VorlaufHK8($n){
			$this->vorlaufHK8 = $this->get_float($n);
		}
		function set_RaumTempHK0($n){
			$this->raumtempHK0 = $this->get_float($n);
		}
		function set_RaumTempHK1($n){
			$this->raumtempHK1 = $this->get_float($n);
		}
		function set_RaumTempHK2($n){
			$this->raumtempHK2 = $this->get_float($n);
		}
		function set_RaumTempHK3($n){
			$this->raumtempHK3 = $this->get_float($n);
		}
		function set_RaumTempHK4($n){
			$this->raumtempHK4 = $this->get_float($n);
		}
		function set_RaumTempHK5($n){
			$this->raumtempHK5 = $this->get_float($n);
		}
		function set_RaumTempHK6($n){
			$this->raumtempHK6 = $this->get_float($n);
		}
		function set_RaumTempHK7($n){
			$this->raumtempHK7 = $this->get_float($n);
		}
		function set_RaumTempHK8($n){
			$this->raumtempHK8 = $this->get_float($n);
		}
		function set_Rauchgasauslastung($n){
			$this->rauchgasauslastung = $this->get_float($n);
		}
		function set_Saugzuggeblaese($n){
			$this->saugzuggeblaese = $this->get_float($n);
		}
		function set_StokerProzent($n){
			$this->stokerProzent = $this->get_float($n);
		}
		function set_PumpeHK0($n){
			$this->pumpeHk0 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK1($n){
			$this->pumpeHk1 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK2($n){
			$this->pumpeHk2 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK3($n){
			$this->pumpeHk3 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK4($n){
			$this->pumpeHk4 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK5($n){
			$this->pumpeHk5 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK6($n){
			$this->pumpeHk6 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK7($n){
			$this->pumpeHk7 = $this->Get_EinAusToInt($n);
		}
		function set_PumpeHK8($n){
			$this->pumpeHk8 = $this->Get_EinAusToInt($n);
		}
		function set_Brandschutzklappe($n){
			$this->brandschutzklappe = $this->Get_EinAusToInt($n);
		}
		function set_Fuellstand($n){
			$this->fuellstand = $this->Get_EinAusToInt($n);
		}
		function set_STB($n){
			$this->stb = $this->Get_EinAusToInt($n);
		}
		function set_TKS1($n){
			$this->tks1 = $this->Get_EinAusToInt($n);
		}
		function set_Kesselfreigabe($n){
			$this->kesselfreigabe = $this->Get_EinAusToInt($n);
		}
		
	}

	class guntamatic_api {
		protected $ip;
		protected $guntamtickey;
		protected $urlpath;
		protected $urlcommandpath;
		protected $token;
		protected $synkessel;

		function set_auth($ip, $guntamtickey)
		{
			//LOGOK("set_auth start");
			$this->ip = $ip;
			$this->guntamtickey = $guntamtickey;
			$this->urlpath = "http://" . $ip ."/daqdata.cgi?key=" . $guntamtickey;
			
			$this->synkessel = "PK002"; // Synonym bei Powerchip/Powercorn/Biocom/Pro: PK002 - Synonym bei Therm/Biostar: K0010
			$this->urlcommandpath = "http://" . $ip ."/ext/parset.cgi?key=" . $guntamtickey;
		}

		function logout()
		{
			return true;
		}
		
		function get_guntamatic()
		{
			//LOGOK("get_guntamatic start");
			$guntamatic = new guntamatic_heater();

			$result = $this->get_html($this->urlpath);

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

						$guntamatic->set_Kesseltemp($lines[3]);
						$guntamatic->set_Rauchgasauslastung($lines[4]);
						$guntamatic->set_Saugzuggeblaese($lines[7]);
						$guntamatic->set_StokerProzent($lines[8]);

						$guntamatic->set_Co2($lines[18]);

						// $guntamatic->set_Status($lines[20]);
						$guntamatic->set_Vorlauf($lines[22]);
						$guntamatic->set_Aussentemp($lines[23]);
						$guntamatic->set_PufferO($lines[24]);
						$guntamatic->set_PufferU($lines[25]);
						$guntamatic->set_PumpeHP0($lines[26]);

						$guntamatic->set_WarmwasserTemp($lines[27]);
						$guntamatic->set_PumpeWarmwasser($lines[28]);
						$guntamatic->set_WarmwasserTemp1($lines[29]);
						$guntamatic->set_PumpeWarmwasser1($lines[30]);
						$guntamatic->set_WarmwasserTemp2($lines[31]);
						$guntamatic->set_PumpeWarmwasser2($lines[32]);

						$guntamatic->set_RaumTempHK0($lines[33]);
						$guntamatic->set_PumpeHK0($lines[34]);

						$guntamatic->set_RaumTempHK1($lines[35]);
						$guntamatic->set_VorlaufHK1($lines[37]);
						$guntamatic->set_PumpeHK1($lines[38]);

						$guntamatic->set_RaumTempHK2($lines[40]);
						$guntamatic->set_VorlaufHK2($lines[42]);
						$guntamatic->set_PumpeHK2($lines[43]);
						
						$guntamatic->set_RaumTempHK3($lines[45]);
						$guntamatic->set_PumpeHK3($lines[46]);

						$guntamatic->set_RaumTempHK4($lines[47]);
						$guntamatic->set_VorlaufHK4($lines[49]);
						$guntamatic->set_PumpeHK4($lines[50]);

						$guntamatic->set_RaumTempHK5($lines[52]);
						$guntamatic->set_VorlaufHK5($lines[54]);
						$guntamatic->set_PumpeHK5($lines[55]);

						$guntamatic->set_RaumTempHK6($lines[57]);
						$guntamatic->set_PumpeHK6($lines[58]);

						$guntamatic->set_RaumTempHK7($lines[59]);
						$guntamatic->set_VorlaufHK7($lines[61]);
						$guntamatic->set_PumpeHK7($lines[62]);

						$guntamatic->set_RaumTempHK8($lines[64]);
						$guntamatic->set_VorlaufHK8($lines[66]);
						$guntamatic->set_PumpeHK8($lines[67]);

						$guntamatic->set_Brandschutzklappe($lines[70]);

						$guntamatic->set_VorlaufHK3($lines[71]);
						$guntamatic->set_VorlaufHK6($lines[73]);

						$guntamatic->set_Fuellstand($lines[74]);
						$guntamatic->set_STB($lines[75]);
						$guntamatic->set_TKS1($lines[76]);
						$guntamatic->set_Kesselfreigabe($lines[77]);
						$guntamatic->set_Betrieb($lines[78]);
						$guntamatic->set_Program($lines[79]);
						$guntamatic->set_ProgramHK0($lines[80]);
						$guntamatic->set_ProgramHK1($lines[81]);
						$guntamatic->set_ProgramHK2($lines[82]);
						$guntamatic->set_ProgramHK3($lines[83]);
						$guntamatic->set_ProgramHK4($lines[84]);
						$guntamatic->set_ProgramHK5($lines[85]);
						$guntamatic->set_ProgramHK6($lines[86]);
						$guntamatic->set_ProgramHK7($lines[87]);
						$guntamatic->set_ProgramHK8($lines[88]);


						$guntamatic->set_Leistung($lines[95]);
						$guntamatic->set_Stoerung($lines[96]);
						$guntamatic->set_Stoerung2($lines[97]);						
						$guntamatic->set_Asche($lines[108]);
					}
					else{
						LOGCRIT("Keine Daten empfangen");
					}
				}
			}	

			LOGOK("get_guntamatic finished");	
			return $guntamatic;
		}
		
		private function get_html($htmlurl, $fields = null, $put = null)
		{
			$content = NULL;
			try {
				$ch = curl_init();
			
				// Check if initialization had gone wrong*    
				if ($ch === false) {
					LOGCRIT("failed to initialize");
				}
			
				// Better to explicitly set URL
				curl_setopt($ch, CURLOPT_URL, $htmlurl);

				if ( isset($put) ){ if ($put == true) curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'PUT');}
				// That needs to be set; content will spill to STDOUT otherwise
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// Set more options
				if ( isset($fields) )
				{
					curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($fields));
				}
				
				//LOGCRIT($htmlurl);
					
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
		
		function control($command)
		{
			switch ($command)
			{
				case 'kesselfreigabeAUTO': 		return $this->get_html($this->urlcommandpath . "&syn=". $this->syn . "&value=0");
												break;
				case 'kesselfreigabeAUS': 		return $this->get_html($this->urlcommandpath . "&syn=". $this->syn . "&value=1");
												break;
				case 'kesselfreigabeEIN': 		return $this->get_html($this->urlcommandpath . "&syn=". $this->syn . "&value=2");
				
												break;
				case 'reglerAUS':		 		return $this->get_html($this->urlcommandpath . "&syn=PR001&value=0");
												break;
				case 'reglerNORMAL':	 		return $this->get_html($this->urlcommandpath . "&syn=PR001&value=1");
												break;
				case 'reglerWarmwasser':		return $this->get_html($this->urlcommandpath . "&syn=PR001&value=3");
												break;
				case 'reglerHandbetrieb':		return $this->get_html($this->urlcommandpath . "&syn=PR001&value=8");
												break;

				case 'HK0AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK001&value=0");
												break;
				case 'HK0NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK001&value=1");
												break;
				case 'HK0HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK001&value=2");
												break;
				case 'HK0ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK001&value=3");
												break;	

				case 'HK1AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK101&value=0");
												break;
				case 'HK1NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK101&value=1");
												break;
				case 'HK1HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK101&value=2");
												break;
				case 'HK1ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK101&value=3");
												break;											

				case 'HK2AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK201&value=0");
												break;
				case 'HK2NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK201&value=1");
												break;
				case 'HK2HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK201&value=2");
												break;
				case 'HK2ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK201&value=3");
												break;
												
				case 'HK3AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK301&value=0");
												break;
				case 'HK3NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK301&value=1");
												break;
				case 'HK3HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK301&value=2");
												break;
				case 'HK3ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK301&value=3");
												break;
				
				case 'HK4AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK401&value=0");
												break;
				case 'HK4NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK401&value=1");
												break;
				case 'HK4HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK401&value=2");
												break;
				case 'HK4ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK401&value=3");
												break;
												
				case 'HK5AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK501&value=0");
												break;
				case 'HK5NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK501&value=1");
												break;
				case 'HK5HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK501&value=2");
												break;
				case 'HK5ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK501&value=3");
												break;
						
				case 'HK6AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK601&value=0");
												break;
				case 'HK6NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK601&value=1");
												break;
				case 'HK6HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK601&value=2");
												break;
				case 'HK6ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK601&value=3");
												break;
												
				case 'HK7AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK701&value=0");
												break;
				case 'HK7NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK701&value=1");
												break;
				case 'HK7HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK701&value=2");
												break;
				case 'HK7ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK701&value=3");
												break;
												
				case 'HK8AUS':					return $this->get_html($this->urlcommandpath . "&syn=HK801&value=0");
												break;
				case 'HK8NORMAL':				return $this->get_html($this->urlcommandpath . "&syn=HK801&value=1");
												break;
				case 'HK8HEIZEN':				return $this->get_html($this->urlcommandpath . "&syn=HK801&value=2");
												break;
				case 'HK8ABSENKEN':			    return $this->get_html($this->urlcommandpath . "&syn=HK801&value=3");
												break;
												
				case 'WW0Nachladen':			return $this->get_html($this->urlcommandpath . "&syn=BK006&value=1");
												break;
				case 'WW1Nachladen':			return $this->get_html($this->urlcommandpath . "&syn=BK106&value=1");
												break;
				case 'WW2Nachladen':			return $this->get_html($this->urlcommandpath . "&syn=BK206&value=1");
												break;

				case 'WWZus0Nachladen':			return $this->get_html($this->urlcommandpath . "&syn=ZK006&value=1");
												break;
				case 'WWZus1Nachladen':			return $this->get_html($this->urlcommandpath . "&syn=ZK106&value=1");
												break;
				case 'WWZus2Nachladen':			return $this->get_html($this->urlcommandpath . "&syn=ZK206&value=1");
												break;
					
				}
		}

		function settings($data = null)
		{
			$result = $this->get_api("mowers/".$mover_id."/settings", array("settings" => $data), true);
			if ($result==NULL) {
				$result->status = "OK";
			}
			return $result;
		}
	}
?>