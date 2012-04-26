<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called vote4coins
 * It allowes users.. well.. to vote.. for coins..
 */
include($config["path"]["includes"].$config["path"]["plugins"]."vote4coins/config.inc.php");
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) 
	$content = array(
		"head" => array(
			"title" => $lang["misc"]["vote4coins"],
		),
		"middle" => array(
			"text" => str_replace("%time",ceil($plugin_conf["wtime"]/3600),str_replace("%coins",$plugin_conf["cpv"],$lang["vote"]["desc"]))."<br/><br/>".$lang["misc"]["needlogin"]
		),
	);
else{
	$content = array(
		"head" => array(
			"title" => $lang["misc"]["vote4coins"],
		),
		"middle" => array(
			"text" => str_replace("%time",ceil($plugin_conf["wtime"]/3600),str_replace("%coins",$plugin_conf["cpv"],$lang["vote"]["desc"])).'<br/><br/><input type="button" class="btn" id="votebtn" value="'.$lang["misc"]["vote"].'" onclick="javascript:vote()"/><div id="voteres"></div>'.$lang["vote"]["howto"]
		),
	);
}
unset($plugin_conf);
?>