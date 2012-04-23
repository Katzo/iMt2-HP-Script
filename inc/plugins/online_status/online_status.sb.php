<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called online status
 * It shows the online status (duh) of defined ports
 */
include($config["path"]["includes"].$config["path"]["plugins"]."online_status/config.inc.php");
if (!isset($db->game) && !isset($db->hp)) $this->error("I could not find any database connection! :(");
if (isset($db->hp)) 
	$cachedq = mysql_query("SELECT * FROM ".$db->hpdb["homepage"].".online_status ORDER BY time DESC LIMIT 1",$db->hp);
else
	$cachedq = mysql_query("SELECT * FROM ".$db->gamedb["homepage"].".online_status  ORDER BY time DESC LIMIT 1",$db->game);
$cached = mysql_fetch_object($cachedq);
if (!isset($cached->time) || time() > $cached->time+$plugin_conf["cachetimeout"]) {
	$status = array();
		foreach($plugin_conf["check"] as $ar) {
			try{
				$c = @fsockopen($ar["host"],$ar["port"],$errno,$errstr,$plugin_conf["timeout"]);
			if (isset($c) && $c) {
				fclose($c);
				$status[] = array("name" => $ar["name"],"status" => 1);
			}else
				$status[] = array("name" => $ar["name"],"status" => 0);
			}
			catch (ErrorException $e){}
		}
	
	$status = json_encode($status);
	if (isset($db->hp)) 
		mysql_query("INSERT INTO ".$db->hpdb["homepage"].".online_status (time,enc) VALUES('".time()."','".$status."')",$db->hp);
	else
		mysql_query("INSERT INTO ".$db->gamedb["homepage"].".online_status (time,enc) VALUES('".time()."','".$status."')",$db->game);
}
$out = "";
if (isset($cached->enc)) {
	$status = json_decode($cached->enc,true);
	
	foreach($status as $stat) 
		if ($stat["status"])
			$out .= '<p class="on">'.$stat["name"]." ".$plugin_conf["online"].'</p><div class="sb-sep"></div>';
		else
			$out .= '<p class="off">'.$stat["name"]." ".$plugin_conf["offline"].'</p><div class="sb-sep"></div>';
}
$content = array("head" => array("title" => $plugin_conf["title"]),"middle" => array("text" => $out));
unset($plugin_conf);
?>
