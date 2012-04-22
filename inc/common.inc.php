<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
 function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
date_default_timezone_set($config["settings"]["timezone"]);
set_error_handler("exception_error_handler");
/*
 * Class Autoloading 
 */
spl_autoload_register("__autoload");
function __autoload($name) {
 	global $config;
 	include($config["path"]["includes"].$config["path"]["classes"].$name.".class.php");
}
/*
 * Current Page
 */
if (isset($isajax)) // Ajax request are still using $_GET["p"]
	$p = ((isset($_GET["p"])&&!empty($_GET["p"]))?$_GET["p"]:"home");
else
	$p = ((isset($_SERVER['PATH_INFO'])&&!empty($_SERVER["PATH_INFO"]))?substr($_SERVER['PATH_INFO'],1):"home");
function e404() {
	header("Status: 404 Not Found");
	die("<h1>I made a mistake! Help! :(</h1>I could not find the page you were looking for... :(");
}
/*
 * time functions
 */
function timetostr($timestamp) {
	global $lang;
	if (!$timestamp) return false;
	$now = time();
	$dif = $now-$timestamp;
	if ($dif < 60) 
		return timeformat($lang["time"]["af"],$lang["time"]["s"]);
	$minutes = floor($dif/60);
	if ($minutes<4)
		return timeformat($lang["time"]["af"],$lang["time"]["m"]);
	if ($minutes < 60)
		return timeformat($minutes,$lang["time"]["m"]);
	$hours = floor($minutes/60);
	if ($hours == 1)
		return timeformat(1,$lang["time"]["H"]);
	if ($hours < 24)
		return timeformat($hours,$lang["time"]["h"]);
	return date($lang["time"]["tformat"],$timestamp);
}
function timeformat($value,$time) {
	global $lang;
	return str_replace("%ago",$lang["time"]["a"],str_replace("%time",$time,str_replace("%value",$value,$lang["time"]["format"])));
}
/*
 * Function for checking on valid URL (used for images)
 */ 
function isURL($url){
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
?>
