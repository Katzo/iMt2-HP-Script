<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 */
$q = mysql_query("SELECT player.id,player.name,player.level,player.job FROM ".$db->gamedb["player"].".player JOIN ".$db->gamedb["account"].".account ON player.account_id = account.id LEFT JOIN ".$db->gamedb["common"].".gmlist ON gmlist.mName = player.name WHERE gmlist.mName is null AND account.status = 'OK' ORDER BY level DESC,exp DESC",$db->game); 
$i=0; // General
$wi=0; // Warrior
$ai=0; // Assasin (spelling..)
$sui=0; // Sura
$sai=0; // Shaman
while ($res = mysql_fetch_object($q)) {
	if (isset($db->hp)) 
		$c = mysql_fetch_object(mysql_query("SELECT time FROM ".$db->hpdb["homepage"].".ranking_cache WHERE id='".$res->id."'",$db->hp));
	else
		$c = mysql_fetch_object(mysql_query("SELECT time FROM ".$db->gamedb["homepage"].".ranking_cache WHERE id='".$res->id."'",$db->hp));
	if (time() < $c->time+$plugin_cache["cachetimeout"]*1.5)
		continue;
	$i++;
	if ($res->job > 3)
		$res->job -=4;
	if ($res->job == 0) {
		$wi++;
		$jr = $wi;
	}
	if ($res->job == 1) {
		$ai++;
		$jr = $ai;
	}
	if ($res->job == 2 ) {
		$sui++;
		$jr = $sui;
	}
	if ($res->job == 3) {
		$sai++;
		$jr = $sai;
	}
	if (isset($db->hp))
		mysql_query("REPLACE INTO ".$db->hpdb["homepage"].".ranking_cache VALUES('".$i."','".$jr."','".$res->id."','".$res->name."','".$res->job."','".$res->level."','".time()."')",$db->hp);
	else
		mysql_query("REPLACE INTO ".$db->gamedb["homepage"].".ranking_cache VALUES('".$i."','".$jr."','".$res->id."','".$res->name."','".$res->job."','".$res->level."','".time()."')",$db->game);
}
if (isset($db->hp))
	mysql_query("ALTER TABLE ".$db->hpdb["homepage"].".ranking_cache comment='".time()."'",$db->hp);
else
	mysql_query("ALTER TABLE ".$db->gamedb["homepage"].".ranking_cache comment='".time()."'",$db->game);
?>