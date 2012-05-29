<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * It's part of the userpanel plugin buts probably more basic (its made for it though!)
 */
if (!isset($_POST["user"]) || !isset($_POST["pass"]))
	exit;
if (empty($_POST["user"]) || empty($_POST["pass"]))
	die(json_encode(array("error" => $lang->get("fillout"))));
$q = mysql_query("SELECT ".$settings->get("coin")." as coins,login,id,status,UNIX_TIMESTAMP(availDt) as bt FROM ".$db->gamedb["account"].".account WHERE login='".mysql_real_escape_string($_POST["user"])."' and password=password('".mysql_real_escape_string($_POST["pass"])."') LIMIT 1",$db->game);
if (!$q)
	die(json_encode(array("error" => $lang->get("userpanel_login_failed"))));
$res = mysql_fetch_object($q);
if (!$res)
	die(json_encode(array("error" => $lang->get("userpanel_login_failed"))));
if ($res->status != "OK" || $res->bt > time())
	die(json_encode(array("error" => $lang->get("userpanel_banned"))));
$_SESSION["user"] = $res->login;
$_SESSION["id"] = $res->id;
$_SESSION["coins"] = $res->coins;
die(json_encode(array("ok" => true)));
?>