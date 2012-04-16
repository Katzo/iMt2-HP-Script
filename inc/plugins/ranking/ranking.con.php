<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "ranking"
 * guess what it does.
 */
include($config["path"]["includes"].$config["path"]["plugins"]."ranking/config.inc.php");
if ($plugin_conf["buildcache"]) {
	/*
	 * Check if we need to rebuild the cache
	 */
	 if (isset($db->hp)) 
	 	$q = mysql_query("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db->hpdb["homepage"]."' and TABLE_NAME='ranking_cache' LIMIT 1",$db->hp);
	 else
	 	$q = mysql_query("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db->gamedb["homepage"]."' and TABLE_NAME='ranking_cache' LIMIT 1",$db->game);
	$res = mysql_fetch_object($q);
	if (time() > $res->TABLE_COMMENT+$plugin_conf["cachetimeout"]) 
		include($config["path"]["includes"].$config["path"]["plugins"]."ranking/buildcache.inc.php");
		// I want to say this again. IT IS REALLY STUPID TO DO THIS
}
$content = array(
	"head" => array(
		"title" => $lang["misc"]["ranking"]
	),
	"middle" => array(
		"text" => '<form onsubmit="javascript:g_rname=$(\'#rname\').val();g_rpage=1;ranking();return false;"><div class="rankingsearch"><input type="text" id="rname" class="bar" onblur="javascript:g_rname=$(this).val();g_rpage=1;ranking();" placeholder="'.$lang["misc"]["charname"].'"/><input class="btn" type="submit" value="'.$lang["misc"]["search"].'"/></div></form>
				<div class="rankingbuttons"><input class="btn" type="button" value="'.$lang["misc"]["allclasses"].'" onclick="javascript:g_rjob=-1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["warrior"].'" onclick="javascript:g_rjob=0;g_rpage=1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["assassin"].'" onclick="javascript:g_rjob=1;g_rpage=1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["sura"].'" onclick="javascript:g_rjob=2;g_rpage=1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["shaman"].'" onclick="javascript:g_rjob=3;g_rpage=1;ranking();"/></div>
				<br/><br/><br/>
				<img id="rloading" src="images/ui/loading_bar.gif" style="margin:auto;display:block;"/>
				<div id="rankingres" class="ranking"></div>'
	)
);
unset($plugin_conf);
?>