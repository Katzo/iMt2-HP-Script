<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called itemshop
 * It helps you to make money with your server. (When you make enough money please consider donating to help me make more stuff like this!)
 * You can offer packages and single items.
 */
include($config["path"]["includes"].$config["path"]["plugins"]."itemshop/config.inc.php");
$content=array(
	"multi" => true
);
if (isset($db->hp))
	$q = mysql_query('SELECT id,name FROM '.$db->hpdb["homepage"].'.itemshop_category WHERE enabled=1',$db->hp);
else
	$q = mysql_query('SELECT id,name FROM '.$db->gamedb["homepage"].'.itemshop_category WHERE enabled=1',$db->game);
$cat = '';
while ($res = mysql_fetch_object($q))
	$cat.='<input type="button" onclick="location.href=\''.$urlmap["itemshop"].'&cat='.$res->id.'\'"class="btn" value="'.$res->name.'"/>';
$content[] = array(
	"head" => array(
		"title" => $lang["misc"]["itemshop"]
	),
	"middle" => array(
		"text" => '<div style="text-align:center;">'.(isset($_SESSION["user"]) && !empty($_SESSION["user"])?str_replace("%coinname",$lang["misc"]["coins"],str_replace("%coins",$_SESSION["coins"],$lang["misc"]["youcoin"])).' <a href="'.$urlmap["donate"].'">'.$lang["misc"]["donate"].'?</a>
			<div class="sep"></div>':'').'<div style="margin:auto">'.$cat.'</div></div>'
	)
);

if (isset($db->hp))
	$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->hpdb["homepage"].'.itemshop_package WHERE enabled=1 ORDER BY added DESC LIMIT '.$plugin_conf["newest_count"],$db->hp);
else
	$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->gamedb["homepage"].'.itemshop_package WHERE enabled=1 ORDER BY added DESC LIMIT '.$plugin_conf["newest_count"],$db->game);
while ($res = mysql_fetch_object($q)) {
	$content[]=array(
		"head" => array(
			"title" => $res->name,
		),
		"middle" => array(
			"img" => array("src" => $res->img,"alt" => $res->name),
			"text" => $res->desc,
		),
		"footer" => array(
			"plain" => $lang["itemshop"]["price"].': <b>'.$res->price.'</b> '.($res->price==1?$lang["misc"]["coin"]:$lang["misc"]["coins"]).(isset($_SESSION["user"])&&!empty($_SESSION["user"])?' <a onclick="javascript:buy(this,'.$res->id.');return false;" class="more right">'.$lang["itemshop"]["buy"].'</a>':'')
		)
	);
}
 	
unset($plugin_conf);
?>