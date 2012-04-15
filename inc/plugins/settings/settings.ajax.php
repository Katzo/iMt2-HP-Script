<?php
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) die(json_encode(array("error" => "Please login!")));
if (isset($_POST["changepw"])){
	if (!isset($_POST["pass"]) || !isset($_POST["repeat"]) || !isset($_POST["oldpass"])) exit;
	if (empty($_POST["pass"]) || empty($_POST["repeat"]) || empty($_POST["oldpass"]))
		die(json_encode(array("error" => $lang["misc"]["fillout"])));
	if ($_POST["pass"] === $_POST["repeat"]){
		include($config["path"]["includes"].$config["path"]["plugins"]."register/config.inc.php");
		if (strlen($_POST["pass"]) > $plugin_conf["maxpasslen"])
			die(json_encode(array("error" => str_replace("%len",$plugin_conf["maxpasslen"],$lang["reg"]["passmaxlen_error"]))));
		if (strlen($_POST["pass"]) < $plugin_conf["minpasslen"])
			die(json_encode(array("error" => str_replace("%len",$plugin_conf["minpasslen"],$lang["reg"]["passminlen_error"]))));
		mysql_query("UPDATE ".$db->gamedb["account"].".account SET password=password('".mysql_real_escape_string($_POST["pass"])."') WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["oldpass"])."')",$db->game);
		if (mysql_affected_rows($db->game)) {
			die(json_encode(array("ok" => $lang["settings"]["pass_changed"])));
		}else
			die(json_encode(array("error" => $lang["settings"]["pass_error"])));
	}else
		die(json_encode(array("error" => $lang["reg"]["passrepeat_error"])));
}elseif(isset($_POST["changecode"])){
	if (!isset($_POST["code"]) || !isset($_POST["pass"])) exit;
	if (empty($_POST["code"]) || empty($_POST["pass"]))
		die(json_encode(array("error" => $lang["misc"]["fillout"])));
	if (strlen($_POST["code"])==7){
		mysql_query("UPDATE ".$db->gamedb["account"].".account SET social_code='".mysql_real_escape_string($_POST["code"])."' WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["pass"])."')",$db->game);
		if (mysql_affected_rows($db->game)) {
			die(json_encode(array("ok" => $lang["settings"]["code_changed"])));
		}else
			die(json_encode(array("error" => $lang["settings"]["pass_error"])));
	}else
		die(json_encode(array("error" => $lang["reg"]["codelen_error"])));
}elseif(isset($_POST["safebox"])){
	if (!isset($_POST["pass"])) exit;
	$q=mysql_query("SELECT id FROM ".$db->gamedb["account"].".account WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["pass"])."')",$db->game);
	if (mysql_num_rows($q)) {
		mysql_query("UPDATE ".$db->gamedb["player"].".safebox SET password='000000' WHERE accound_id='".$_SESSION["id"]."'");
		die(json_encode(array("ok" => $lang["settings"]["safebox_reseted"])));
	}else
		die(json_encode(array("error" => $lang["settings"]["pass_error"])));

}elseif(isset($_POST["changeemail"])){
	include($config["path"]["includes"].$config["path"]["plugins"]."settings/config.inc.php");
	if (!isset($_POST["pass"]) || !isset($_POST["email"])) exit;
	if (empty($_POST["pass"]) || empty($_POST["email"]))
		die(json_encode(array("error" => $lang["misc"]["fillout"])));
	if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})^", $_POST["email"])) 
           	die(json_encode(array("error" => $lang["reg"]["email_error"])));
	$q=mysql_query("SELECT email FROM ".$db->gamedb["account"].".account WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["pass"])."')",$db->game);
	if (!mysql_num_rows($q)) 
		die(json_encode(array("error" => $lang["settings"]["pass_error"])));
	if ($plugin_conf["email_verify"]){
		$res = mysql_fetch_object($q);
		$key1 = md5(microtime().uniqid());
		$key2 = md5(uniqid().microtime());
		if (isset($db->hp))
			mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.email_change VALUES("'.$_SESSION["id"].'","'.mysql_real_escape_string($_POST["email"]).'","'.$key1.'","'.$key2.'",0)',$db->hp);
		else
			mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.email_change VALUES("'.$_SESSION["id"].'","'.$key1.'","'.$key2.'",0)',$db->game);
		mail($_POST["email"],str_replace("%username",$_POST["user"],$lang["settings"]["emailsubject"]),str_replace("%key",$key2,str_replace("%username",$_POST["user"],$lang["settings"]["emailbody2"])),$config["settings"]["email_header"]);
		mail($res->email,str_replace("%username",$_POST["user"],$lang["settings"]["emailsubject"]),str_replace("%key",$key1,str_replace("%username",$_POST["user"],$lang["settings"]["emailbody1"])),$config["settings"]["email_header"]);
		die(json_encode(array("ok" => $lang["settings"]["verifymailsent"])));
	}
	mysql_query('UPDATE '.$db->gamedb.'.account SET email="'.mysql_real_escape_string($_POST["email"]).'" WHERE id="'.$_SESSION["id"].'"');
	die(json_encode(array("ok" => $lang["settings"]["email_changed"])));
}
?>