<?php
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) die(json_encode(array("error"=>$lang["misc"]["needlogin"])));
if (isset($db->hp)) 
	$q = mysql_query('SELECT price FROM '.$db->hpdb["homepage"].'.itemshop_package WHERE enabled=1 and id="'.mysql_real_escape_string($_POST["id"]).'"',$db->hp);
else
	$q = mysql_query('SELECT price FROM '.$db->gamedb["homepage"].'.itemshop_package WHERE enabled=1 and id="'.mysql_real_escape_string($_POST["id"]).'"',$db->game);
$info = mysql_fetch_object($q);
if (!$info) die(json_encode(array("error" => $lang["itemshop"]["itemerror"])));
if ($_SESSION["coins"] < $info->price) die(json_encode(array("error" => $lang["itemshop"]["priceerror"])));
$realcoins = mysql_fetch_object(mysql_query("SELECT ".$config["settings"]["coin"]." as coins FROM ".$db->gamedb["account"].".account WHERE id='".$_SESSION["id"]."' LIMIT 1",$db->game))->coins;
//if ($realcoins != $_SESSION["coins"]) dostuff(); <- Comming later. Probably. Maybe.
if ($realcoins < $info->price) die(json_encode(array("error" => $lang["itemshop"]["priceerror"])));
if (isset($db->hp))
	$q = mysql_query("SELECT vnum,count,socket0,socket1,socket2 FROM ".$db->hpdb["homepage"].".itemshop_item WHERE pid='".mysql_real_escape_string($_POST["id"])."'",$db->hp);
else
	$q = mysql_query("SELECT vnum,count,socket0,socket1,socket2 FROM ".$db->gamedb["homepage"].".itemshop_item WHERE pid='".mysql_real_escape_string($_POST["id"])."'",$db->game);
while ($res = mysql_fetch_object($q)) {
	mysql_query('INSERT INTO '.$db->gamedb["player"].'.item_affect (login,vnum,count,given_time,why,socket0,socket1,socket2,mall) VALUES("'.$_SESSION["user"].'","'.$res->vnum.'","'.$res->count.'",NOW(),"Itemshop IP:'.$_SERVER["REMOTE_ADDR"].' Package:'.mysql_real_escape_string($_POST["pid"]).'","'.$res->socket0.'","'.$res->socket1.'","'.$res->socket2.'")',$db->game);
	if (mysql_affected_rows($db->game) == 0)
		die(json_encode(array("error" => "Server Error. Try again.")));
}
mysql_query('UPDATE '.$db->gamedb["account"].'.account SET '.$config["settings"]["coin"].' = "'.($realcoins-$info->price).'" WHERE id="'.$_SESSION["id"].'" LIMIT 1',$db->game);
$_SESSION["coins"] = $realcoins-$info->price;
if ($_POST["ingame"]) // Yay! When user reaches this he successfully bought something! money! $_$
	die(json_encode(array("ok" => $lang["itemshop"]["success_ingame"].'<a onclick="javascript:buy($(this).parent(),'.$_POST["id"].');return false;" class="more">'.$lang["itemshop"]["buy_again"].'</a>'))); 
else
	die(json_encode(array("ok" => $lang["itemshop"]["success"].'<a onclick="javascript:buy($(this).parent(),'.$_POST["id"].');return false;" class="more">'.$lang["itemshop"]["buy_again"].'</a>')));
?>
