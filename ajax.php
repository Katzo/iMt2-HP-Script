<?php
try{
	if (!file_exists("common.inc.php")) throw new Exception("Could not find common.inc.php!\nYou are screwed! :3");
	include("common.inc.php");
	if (!file_exists("config.inc.php")) throw new CException("Could not find config.inc.php!\nPlease read instructions on how to install this script.\n<a href='http://www.elitepvpers.com/forum/metin2-pserver-guides-strategies/1836740-imt2-homepage-script-alpha.html'>Click here!</a>");
	include("config.inc.php");
	
	$db = new database;
	$ConfigProvider = new ConfigProvider;
	$settings = $ConfigProvider->get("settings");
	$lang = new lang($ConfigProvider->get("lang"));
	session_name($settings->get("session_name"));
	session_start();
	date_default_timezone_set($settings->get("timezone"));
	$p = loadp();
	if (!isset($pages[$p])) throw new CException("I could not find the page '".$p."' you where looking for.<br/>I am sorry :(");
	include($config["path"]["includes"]."pluginloader.inc.php");
}catch(CException $e){
	if (isset($_GET["json"]))
		echo '{"error":"An error occured, please view the error log for more information!"}';
	else
		echo "An error occured, please view the error log for more information!";
	throw $e;
}catch(CErrorException $e){
	if (isset($_GET["json"]))
		echo '{"error":"An error occured, please view the error log for more information!"}';
	else
		echo "An error occured, please view the error log for more information!";
	throw $e;
}
?>
