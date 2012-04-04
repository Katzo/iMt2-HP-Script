<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
if (!isset($_POST["user"]) || !isset($_POST["pass"]))
	exit;
if (empty($_POST["user"]) || empty($_POST["pass"]))
	die(json_encode(array("error" => $lang["misc"]["fillout"])));
if (!isset($db->game)) 
	die(json_encode(array("error" => "Database connection game not set! Help!")));
if (!isset($db->gamedb["account"])) 
	die(json_encode(array("error" => "Database index account not set! Help!")));
$q = mysql_query("SELECT ".$config["settings"]["coin"]." as coins,login,id FROM ".$db->gamedb["account"].".account WHERE login='".mysql_real_escape_string($_POST["user"])."' and password=password('".mysql_real_escape_string($_POST["pass"])."') LIMIT 1",$db->game);
if (!$q)
	die(json_encode(array("error" => $lang["misc"]["noacc"])));
$res = mysql_fetch_object($q);
if (!$res)
	die(json_encode(array("error" => $lang["misc"]["noacc"])));
$_SESSION["user"] = $res->login;
$_SESSION["id"] = $res->id;
$_SESSION["coins"] = $res->coins;
die(json_encode(array("ok" => true)));
?>