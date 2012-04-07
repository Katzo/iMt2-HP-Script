<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called sbranking
 * It shows a small ranking in the sidebar
 * It requires the default Ranking script (cached ranking database)
 */
 
include($config["path"]["includes"].$config["path"]["plugins"]."sbranking/config.inc.php");
if ($plugin_conf["buildcache"]) {
	/*
	 * Check if we need to rebuild the cache
	 */
	 if (isset($db->hp)) 
	 	$q = mysql_query("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db->hpdb["homepage"]."' and TABLE_NAME='ranking_cache' LIMIT 1",$db->hp);
	 else
	 	$q = mysql_query("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db->gamedb["homepage"]."' and TABLE_NAME='ranking_cache' LIMIT 1",$db->game);
	$res = mysql_fetch_object($q);
	if ($res && time() > $res->TABLE_COMMENT+$plugin_conf["cachetimeout"]) 
		include($config["path"]["includes"].$config["path"]["plugins"]."ranking/buildcache.inc.php");
		// I want to say this again. IT IS REALLY STUPID TO DO THIS (FOR LARGER DATABASES!)
}
if (isset($db->hp)) 
	$q = mysql_query("SELECT i,name,level FROM ".$db->hpdb["homepage"].".ranking_cache ORDER BY i DESC LIMIT 10",$db->hp);
else
	$q = mysql_query("SELECT i,name,level FROM ".$db->gamedb["homepage"].".ranking_cache ORDER BY i DESC LIMIT 10",$db->game);
$b = "";
while ($res = mysql_fetch_object($q))
	$b .="<tr><td>".$res->i."</td><td>".$res->name."</td><td>".$res->level."</td></tr>";
$content = array(
	"head" => array(
		"title" => $lang["misc"]["ranking"]
	),
	"middle" => array(
		"title" => '<table class="sbranking"><tr><td>#</td><td>'.$lang["misc"]["username"].'</td><td></td>'.$b."</table>"
	)
);
unset($plugin_conf);
?>
