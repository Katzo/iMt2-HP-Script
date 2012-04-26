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
else{
	if (isset($_SERVER["PATH_INFO"]) && !empty($_SERVER["PATH_INFO"])){ // No mod_rewrite
		$p = substr($_SERVER["PATH_INFO"],1);
	// mod_rewrite 
	}elseif (isset($_GET["p"]))
		$p = ((isset($_GET["p"])&&!empty($_GET["p"]))?$_GET["p"]:"home"); // old $_GET["p"] behaviour
	elseif($_SERVER["REQUEST_URI"] != $_SERVER["SCRIPT_NAME"]){ // Check if page "empty"
		$p = explode("?",substr($_SERVER["REQUEST_URI"],1));
		$p = $p[0];
		$urlbase = substr(substr(parse_url($config["settings"]["baseurl"],PHP_URL_PATH),1),0,-1);
		$p = str_replace($urlbase,"",$p);
		if (strlen($p) < 2)
			$p = "home";
		else{
			if (substr($p,-1) == "/")
				$p = substr($p,0,-1);
			if ($p[0] == "/")
				$p = substr($p,1);
			if (empty($p))
				$p = "home";
		}
	}else
		$p = "home"; //"empty"
}

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
function tvtostring($time){ // Time value to string
	global $lang;
	$days = floor($time/86400);
	$r = $time%86400;
	$hours = floor($r/3600);
	$r = $r%3600;
	$minutes = ceil($r/60);
	$str = "<!--".$time."-->";
	if ($days > 0)
		$str .= $days." ".($days==1?$lang["time"]["D"]:$lang["time"]["d"])." ";
	if ($hours > 0)
		$str .= $hours." ".($hours==1?$lang["time"]["H"]:$lang["time"]["h"])." ";
	if ($minutes > 0)
		$str .= $minutes." ".($minutes==1?$lang["time"]["M"]:$lang["time"]["m"])." ";
	return $str;
}
/*
 * Function for checking on valid URL (used for images)
 */ 
function isURL($url){
	return preg_match('|^[a-z0-9-]+?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
?>
