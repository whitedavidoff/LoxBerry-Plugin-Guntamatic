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

if ($cmd = $_GET["CMD"]) LOGSTART("Guntamatic send cmd:".$cmd." started");
else 
{
	LOGCRIT("ERROR received from Guntamatic Connect API - unnown  command");
	LOGEND("Processing terminated");
	exit;
}

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

//LOGOK("Data USER:".$guntamaticCfg->get("GUNTAMATIC","USERNAME")." PW:".$guntamaticCfg->get("GUNTAMATIC","PASSWORD"));

//Neues Guntamatic Objekt anlegen. Username und Passwort werden aus cfg Datei gelesen.
$session_guntamatic = new guntamatic_api();
$session_guntamatic->set_auth($guntamaticCfg->get("GUNTAMATIC","GUNTAMATICIP"), $guntamaticCfg->get("GUNTAMATIC","GUNTAMATICKEY"));

//LOGOK("Data received from Guntamatic Connect API:".json_encode($mowerlist));

// Kommando vomMiniserver erhalten welches an den Automower weitergeleitet werden muss
// Kommandos: "park", "pause", "start3h"

LOGOK("Send command '".$cmd."' to Guntamatic Connect API");

if(strpos($cmd,"cuttingHeight:")!==false) $res = $session_guntamatic->settings($mowerID,array("cuttingHeight"=> intval(preg_replace('/[^0-9]/', '', $cmd))));
elseif(strpos($cmd,"ecoMode:")!==false) 
{   
    if (intval(preg_replace('/[^0-9]/', '', $cmd))==0) $val=false; else $val=true;
	$res = $session_guntamatic->settings($mowerID,array("ecoMode"=> $val));
}
else $res= $session_guntamatic->control($mowerID, $cmd);

$session_guntamatic->logout();
if ($res->status === "OK")
{ 
   LOGOK("Command sucessfully executed");
}
else LOGCRIT("ERROR received from Guntamatic Connect API".json_encode ($res));
	
LOGEND("Processing terminated");
?>
