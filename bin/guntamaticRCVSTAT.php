#!/usr/bin/php
<?php
	require_once "loxberry_system.php";
	require_once "loxberry_log.php";
	require_once "Config/Lite.php";
	require_once "$lbphtmldir/guntamatic_api.class.php";
	require_once "$lbphtmldir/functions.inc.php";

	$miniserverIP = "";
	$log = Null;
	$guntamaticCfg = Null;
	$Guntamatic = Null;
	$msArray = Null;
	$msID = 0;

	// Creates a log object, automatically assigned to your plugin, with the group name "GardenaLog"
	$log = LBLog::newLog( [ "name" => "GuntamaticLog", "package" => $lbpplugindir, "logdir" => $lbplogdir, "loglevel" => 6] );
	// After log object is created, logging is started with LOGSTART
	// A start timestamp and other information is added automatically
	LOGSTART("Guntamatic rcvstatus started");

	$guntamaticCfg = new Config_Lite("$lbpconfigdir/guntamatic.cfg",LOCK_EX,INI_SCANNER_RAW);

	if ($guntamaticCfg == Null){
		LOGCRIT("Unable to read config file, terminating");
		LOGEND("Processing terminated");
		exit;
	}
	else {
		LOGOK("Reading config file successfull");
	}

	if ($guntamaticCfg->get("GUNTAMATIC","ENABLED")){
		LOGOK("Plugin is enabled");
	} else{
		LOGOK("Plugin is disabled");
		LOGEND("Processing terminated");
		exit;
	}

	$msArray = LBSystem::get_miniservers();
	$msID = $guntamaticCfg->get("GUNTAMATIC","MINISERVER");
	$miniserverIP = $msArray[$msID]['IPAddress'];

	//Neues Guntamatic Objekt anlegen. KEY werden aus cfg Datei gelesen.
	$session_guntamatic = new guntamatic_api();
	$session_guntamatic->set_auth($guntamaticCfg->get("GUNTAMATIC","GUNTAMATICIP"), $guntamaticCfg->get("GUNTAMATIC","GUNTAMATICKEY"));

	$guntamatic=$session_guntamatic->get_guntamatic();
	//LOGOK("Data received from Guntamatic Connect API:".json_encode($mowerlist));

	$result= array ("status" => $guntamatic->status, "program" => $guntamatic->program, "kesseltemp" => $guntamatic->kesseltemp, "co2" => $guntamatic->co2, "leistung" => $guntamatic->leistung,"pufferO" => $guntamatic->pufferO, "pufferU" => $guntamatic->pufferU, "aussentemp" => $guntamatic->aussentemp, "warmwasser" => $guntamatic->warmwasser, "pumpeHP0" => $guntamatic->pumpeHP0, "asche" => $guntamatic->asche, "stoerung" => $guntamatic->stoerung, "vorlauf" => $guntamatic->vorlauf);

	$dataToSend = json_encode($result);
	$session_guntamatic->logout();

	//Tansfer Data
	sendUDP($dataToSend, $miniserverIP, $guntamaticCfg->get("GUNTAMATIC","UDPPORT"));

	LOGOK("Data sent to Miniserver:".$dataToSend);

	LOGEND("Processing terminated");
?>