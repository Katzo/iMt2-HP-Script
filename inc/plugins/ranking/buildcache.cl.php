<?php
if (php_sapi_name() != "cli") die("You may only execute this script via command line.");
include("../../../config.inc.php");
$game = mysql_connect($config["db"]["game"]["host"],$config["db"]["game"]["user"],$config["db"]["game"]["pass"]);
if (isset($config["db"]["hp"])) {
	$hp = mysql_connect($config["db"]["hp"]["host"],$config["db"]["hp"]["user"],$config["db"]["hp"]["pass"]);
}
$q = mysql_query("SELECT id,name,level,job FROM ".$config["db"]["game"]["db"]["player"].".player ORDER BY level DESC",$game);
$i=0; // General
$wi=0; // Warrior
$ai=0; // Assasin (spelling..)
$sui=0; // Sura
$sai=0; // Shaman
while ($res = mysql_fetch_object($q)) {
	$i++;
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
	if (isset($hp))
		mysql_query("INSERT INTO ".$config["db"]["hp"]["db"]["player"].".ranking_cache_new VALUES('".$i."','".$jr."','".$id."','".$name."','".$job."','".time()."')",$hp);
	else
		mysql_query("INSERT INTO ".$config["db"]["game"]["db"]["player"].".ranking_cache_new VALUES('".$i."','".$jr."','".$id."','".$name."','".$job."','".time()."')",$game);
}
?>