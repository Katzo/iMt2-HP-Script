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
		"text" => '<form onsubmit="javascript:g_rname=$(\'#rname\').val();ranking();return false;"><input type="text" id="rname" class="bar" onblur="javascript:g_rname=$(this).val();ranking();" placeholder="'.$lang["misc"]["charname"].'"/></form>
				<input class="btn" type="button" value="'.$lang["misc"]["alljobs"].'" onclick="javascript:g_rjob=-1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["warrior"].'" onclick="javascript:g_rjob=0;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["assassin"].'" onclick="javascript:g_rjob=1;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["sura"].'" onclick="javascript:g_rjob=2;ranking();"/>
				<input class="btn" type="button" value="'.$lang["misc"]["shaman"].'" onclick="javascript:g_rjob=3;ranking();"/>
				<br/>
				<div id="rankingres"><img src="images/ui/loading_bar.gif"/></div>'
	)
);
unset($plugin_conf);
?>