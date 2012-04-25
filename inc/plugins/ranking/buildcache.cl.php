<?php
if (php_sapi_name() != "cli") die("You may only execute this script via command line.");
include("../../../config.inc.php");
$game = mysql_connect($config["db"]["game"]["host"],$config["db"]["game"]["user"],$config["db"]["game"]["pass"]);
if (isset($config["db"]["hp"])) {
	$hp = mysql_connect($config["db"]["hp"]["host"],$config["db"]["hp"]["user"],$config["db"]["hp"]["pass"]);
}
$q = mysql_query("SELECT player.id,player.name,player.level,player.job FROM ".$config["db"]["game"]["db"]["player"].".player JOIN ".$config["db"]["game"]["db"]["account"].".account ON player.account_id = account.id LEFT JOIN ".$config["db"]["game"]["db"]["common"].".gmlist ON gmlist.mName = player.name WHERE gmlist.mName is null AND account.status = 'OK' AND availDt < NOW() ORDER BY level DESC,exp DESC",$game);
$i=0; // General
$wi=0; // Warrior
$ai=0; // Assasin (spelling..)
$sui=0; // Sura
$sai=0; // Shaman
while ($res = mysql_fetch_object($q)) {
	$i++;
	if ($res->job > 3)
		$res->job -=4;
	if ($res->job == 0 || $res->job == 4) {
		$wi++;
		$jr = $wi;
	}
	if ($res->job == 1 || $res->job == 5) {
		$ai++;
		$jr = $ai;
	}
	if ($res->job == 2 || $res->job == 6) {
		$sui++;
		$jr = $sui;
	}
	if ($res->job == 3 || $res->job == 7) {
		$sai++;
		$jr = $sai;
	}
	// I dont need any fancy rebuilt only things that didnt get rebuilt yet protection here.
	// It just rebuilts the whole table.
	if (isset($hp))
		mysql_query("REPLACE INTO ".$config["db"]["hp"]["db"]["homepage"].".ranking_cache VALUES('".$i."','".$jr."','".$res->id."','".$res->name."','".$res->job."','".$res->level."','".time()."')",$hp);
	else
		mysql_query("REPLACE INTO ".$config["db"]["game"]["db"]["homepage"].".ranking_cache VALUES('".$i."','".$jr."','".$res->id."','".$res->name."','".$res->job."','".$res->level."','".time()."')",$game);
}
if (isset($hp))
	mysql_query("ALTER TABLE ".$config["db"]["hp"]["db"]["player"].".ranking_cache comment='".time()."'",$hp);
else
	mysql_query("ALTER TABLE ".$config["db"]["game"]["db"]["player"].".ranking_cache comment='".time()."'",$game);
?>