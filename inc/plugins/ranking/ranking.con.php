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
$content = array(
	"head" => array(
		"title" => $lang["misc"]["ranking"]
	),
	"middle" => array(
		"text" => '<form onsubmit="javascript:g_rname=$(\'#rname\').val();ranking();return false;"><div class="rankingsearch"><input type="text" id="rname" class="bar" onblur="javascript:g_rname=$(this).val();ranking();" placeholder="'.$lang["misc"]["charname"].'"/><input class="btn" type="submit" value="'.$lang["misc"]["search"].'"/></div></form>
				<div class="rankingbuttons"><input class="btn" type="button" value="'.$lang["misc"]["allclasses"].'" onclick="javascript:g_rjob=-1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["warrior"].'" onclick="javascript:g_rjob=0;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["assassin"].'" onclick="javascript:g_rjob=1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["sura"].'" onclick="javascript:g_rjob=2;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["shaman"].'" onclick="javascript:g_rjob=3;ranking();"/></div>
				<br/><br/><br/>
				<div id="rankingres" class="ranking"><img src="images/ui/loading_bar.gif"/></div>'
	)
);
unset($plugin_conf);
?>