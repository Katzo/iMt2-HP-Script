<?php
if (!isset($_POST["v"]) || empty($_POST["v"])) exit;
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) die(json_encode(array("error" => $lang["misc"]["needlogin"])));
include($config["path"]["includes"].$config["path"]["plugins"]."vote4coins/config.inc.php");
if ($_POST["v"]==1){// Check if he has voted
	if (isset($db->hp))
		$q = mysql_query("SELECT UNIX_TIMESTAMP(time) as t  FROM ".$db->hpdb["homepage"].".vote4coins WHERE uid='".$_SESSION["id"]."' AND ok=1 AND time > DATE_SUB(NOW(), INTERVAL ".$plugin_conf["wtime"]." SECOND) LIMIT 1",$db->hp);
	else
		$q = mysql_query("SELECT UNIX_TIMESTAMP(time) as t FROM ".$db->gamedb["homepage"].".vote4coins WHERE uid='".$_SESSION["id"]."' AND ok=1 AND time > DATE_SUB(NOW(), INTERVAL ".$plugin_conf["wtime"]." SECOND) LIMIT 1",$db->game);
	if (mysql_num_rows($q) != 0) {
		$res = mysql_fetch_object($q);
		die(json_encode(array("error" => str_replace("%time",tvtostring($res->t+$plugin_conf["wtime"]-time()),$lang["vote"]["already"]))));
	}
	if (isset($db->hp))
			$q = mysql_query("SELECT id,count  FROM ".$db->hpdb["homepage"].".vote4coins WHERE uid='".$_SESSION["id"]."' AND ok=0 AND time > DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY time DESC LIMIT 1",$db->hp);
		else
			$q = mysql_query("SELECT id,count FROM ".$db->gamedb["homepage"].".vote4coins WHERE uid='".$_SESSION["id"]."' AND ok=0 AND time > DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY time DESC LIMIT 1",$db->game);
	if (mysql_num_rows($q) != 0) {
		die(json_encode(array("error" => $lang["vote"]["tryagain"])));
	}
	$res = mysql_fetch_object($q);
	if (get_vote_count($plugin_conf["id"]) > $res->count ){
		// Give coins, update stuff.
	if (isset($db->hp))
			$q = mysql_query("UPDATE ".$db->hpdb["homepage"].".vote4coins SET ok=1 WHERE id='".$res->id."' LIMIT 1",$db->hp);
		else
			$q = mysql_query("UPDATE ".$db->gamedb["homepage"].".vote4coins SET SET ok=1 WHERE id='".$res->id."' LIMIT 1",$db->game);
		$_SESSION["coins"] +=$plugin_conf["cpv"];
		mysql_query('UPDATE '.$db->gamedb["account"].'.account SET '.$config["settings"]["coin"].'='.$config["settings"]["coin"].'+'.$plugin_conf["cpv"].' WHERE id="'.$_SESSION["id"].'" LIMIT 1');
		die(json_encode(array("ok" => $lang["vote"]["success"],"btn" => $lang["misc"]["vote"],"v" => 0)));
	}
	
}else{ // Init voting and stuff
	// Check if he has voted within the wtime
	if (isset($db->hp))
		$q = mysql_query("SELECT UNIX_TIMESTAMP(time) as t  FROM ".$db->hpdb["homepage"].".vote4coins WHERE uid='".$_SESSION["id"]."' AND ok=1 AND time > DATE_SUB(NOW(), INTERVAL ".$plugin_conf["wtime"]." SECOND) LIMIT 1",$db->hp);
	else
		$q = mysql_query("SELECT UNIX_TIMESTAMP(time) as t FROM ".$db->gamedb["homepage"].".vote4coins WHERE uid='".$_SESSION["id"]."' AND ok=1 AND time > DATE_SUB(NOW(), INTERVAL ".$plugin_conf["wtime"]." SECOND) LIMIT 1",$db->game);
	if (mysql_num_rows($q) != 0) {
		$res = mysql_fetch_object($q);
		die(json_encode(array("error" => str_replace("%time",tvtostring($res->t+$plugin_conf["wtime"]-time()),$lang["vote"]["already"]))));
	}
	if (isset($db->hp))
		mysql_query("INSERT INTO ".$db->hpdb["homepage"].".vote4coins (uid,time,count) VALUES('".$_SESSION["id"]."','".time()."','".get_vote_count($plugin_conf["id"])."')",$db->hp);
	else
		mysql_query("INSERT INTO ".$db->gamedb["homepage"].".vote4coins (uid,time,count) VALUES('".$_SESSION["id"]."','".time()."','".get_vote_count($plugin_conf["id"])."')",$db->game);
	die(json_encode(array("btn" => $lang["misc"]["check"],"url" => "http://www.topliste.top-pserver.com/In/".$plugin_conf["id"]."-.htm","v" => 1)));
}
function get_vote_count($id){
	ini_set("user_agent","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"); // You need to set a user agent otherwise you will get 169,651 or something
	$page = file_get_contents("http://www.topliste.top-pserver.com/Stat/".$id."-.htm");
	if (!$page) die(json_encode(array("error" => "Server error!")));
	$table = str_between(str_replace("\n","",$page),'<tr class="lightbg" style="font-weight: bold;"><td>Gesamt</td>','</tr>');
	if (!$table) die(json_encode(array("error" => "Server error!")));
	$cell = explode('<td align="center">',str_replace("</td>","",$table)); // 4th one
	if (!isset($cell[4])) die(json_encode(array("error" => "Server error!")));
	return (int)$cell[4];
}
function str_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
}
?>