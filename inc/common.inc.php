<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
 spl_autoload_register("__autoload");
 function __autoload($name) {
 	global $config;
 	include($config["path"]["includes"].$config["path"]["classes"].$name.".class.php");
 }
 $p = ((isset($_GET["p"]))?$_GET["p"]:"home");
 function e404() {
 	header("Status: 404 Not Found");
 	die("<h1>I made a mistake! Help! :(</h1>I could not find the page you were looking for... :(");
 }
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
	return date($lang["time"]["format"],$timestamp);
 }
 function timeformat($value,$time) {
 	global $lang;
 	return str_replace("%ago",$lang["time"]["a"],str_replace("%time",$time,str_replace("%value",$value,$lang["time"]["format"])));
 }
?>
