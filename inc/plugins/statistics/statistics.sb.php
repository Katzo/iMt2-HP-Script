<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called statistics
 * It shows total (online) players, accounts, guilds, items and stuff
 */
include($config["path"]["includes"].$config["path"]["plugins"]."statistics/config.inc.php");
if (!isset($db->game)) $this->error("I could not find the game database connection! :(");
if (isset($db->hp)) 
	$cachedq = mysql_query("SELECT * FROM ".$db->hpdb["homepage"].".statistics ORDER BY time DESC LIMIT 1",$db->hp);
else
	$cachedq = mysql_query("SELECT * FROM ".$db->gamedb["homepage"].".statistics ORDER BY time DESC LIMIT 1",$db->game);
$cached = mysql_fetch_object($cachedq);
if (!isset($cached->time) || time() > $cached->time+$plugin_conf["cachetimeout"]) {
	// Acc total
	$acc = mysql_fetch_object(mysql_query("SELECT count(*) as c FROM ".$db->gamedb["account"].".account",$db->game));
	// Player total
	$player = mysql_fetch_object(mysql_query("SELECT count(*) as c FROM ".$db->gamedb["player"].".player",$db->game));
	// Guild total
	$guild = mysql_fetch_object(mysql_query("SELECT count(*) as c FROM ".$db->gamedb["player"].".guild",$db->game));
	// Item total
	$item = mysql_fetch_object(mysql_query("SELECT count(*) as c FROM ".$db->gamedb["player"].".item",$db->game));
	// Player online
	$playero = mysql_fetch_object(mysql_query("SELECT count(*) as c FROM ".$db->gamedb["player"].".player WHERE last_play > DATE_SUB(NOW(), INTERVAL 10 MINUTE)",$db->game));
	if (isset($db->hp))
		mysql_query("INSERT INTO ".$db->hpdb["homepage"].".statistics (time,acc,player,guild,item,playero) VALUES('".time()."','".$acc->c."','".$player->c."','".$guild->c."','".$item->c."','".$playero->c."')",$db->hp);
	else
		mysql_query("INSERT INTO ".$db->gamedb["homepage"].".statistics (time,acc,player,guild,item,playero) VALUES('".time()."','".$acc->c."','".$player->c."','".$guild->c."','".$item->c."','".$playero->c."')",$db->game);
}
$content = array(
	"head" => array("title" => $plugin_conf["title"]),
	"middle" => array("text" => '<p class="info"><strong>'.$cached->acc.'</strong> '.$plugin_conf["acc"].'</p>' .
				'<div class="sb-sep"></div><p class="info"><strong>'.$cached->playero.'</strong> '.$plugin_conf["playero"].'</p>' .
				'<div class="sb-sep"></div><p class="info"><strong>'.$cached->player.'</strong> '.$plugin_conf["player"].'</p>'.
				'<div class="sb-sep"></div><p class="info"><strong>'.$cached->guild.'</strong> '.$plugin_conf["guild"].'</p>'.
				'<div class="sb-sep"></div><p class="info"><strong>'.$cached->item.'</strong> '.$plugin_conf["item"].'</p>')
);
unset($plugin_conf);
?>
