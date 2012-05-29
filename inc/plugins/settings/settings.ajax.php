<?php
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) die(json_encode(array("error" => $lang["misc"]["needlogin"])));
if (isset($_POST["changepw"])){
	if (!isset($_POST["pass"]) || !isset($_POST["repeat"]) || !isset($_POST["oldpass"])) exit;
	if (empty($_POST["pass"]) || empty($_POST["repeat"]) || empty($_POST["oldpass"]))
		die(json_encode(array("error" => $lang->get("fillout"))));
	if ($_POST["pass"] === $_POST["repeat"]){
		$plugin_conf=$ConfigProvider->get("plugin_register");
		if (strlen($_POST["pass"]) > $plugin_conf->get("maxpasslen"))
			die(json_encode(array("error" => $lang->get("register_passmaxlen_error",array("len"=>$plugin_conf->get("maxpasslen"))))));
		if (strlen($_POST["pass"]) < $plugin_conf->get("minpasslen"))
			die(json_encode(array("error" => $lang->get("register_passminlen_error",array("len"=>$plugin_conf->get("minpasslen"))))));
		mysql_query("UPDATE ".$db->gamedb["account"].".account SET password=password('".mysql_real_escape_string($_POST["pass"])."') WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["oldpass"])."')",$db->game);
		if (mysql_affected_rows($db->game)) {
			die(json_encode(array("ok" => $lang->get("settings_pass_changed"))));
		}else
			die(json_encode(array("error" => $lang->get("settings_pass_error"))));
	}else
		die(json_encode(array("error" => $lang->get("register_passrepeat_error"))));
}elseif(isset($_POST["changecode"])){
	if (!isset($_POST["code"]) || !isset($_POST["pass"])) exit;
	if (empty($_POST["code"]) || empty($_POST["pass"]))
		die(json_encode(array("error" => $lang->get("fillout"))));
	if (strlen($_POST["code"])==7){
		mysql_query("UPDATE ".$db->gamedb["account"].".account SET social_id='".mysql_real_escape_string($_POST["code"])."' WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["pass"])."')",$db->game);
		if (mysql_affected_rows($db->game)) {
			die(json_encode(array("ok" => $lang->get("settings_code_changed"))));
		}else
			die(json_encode(array("error" => $lang->get("settings_pass_error"))));
	}else
		die(json_encode(array("error" => $lang->get("register_codelen_error"))));
}elseif(isset($_POST["resetsafebox"])){
	if (!isset($_POST["pass"])) exit;
	if (empty($_POST["pass"]))
		die(json_encode(array("error" => $lang->get("fillout"))));
	$q=mysql_query("SELECT id FROM ".$db->gamedb["account"].".account WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["pass"])."')",$db->game);
	if (mysql_num_rows($q)) {
		mysql_query("UPDATE ".$db->gamedb["player"].".safebox SET password='000000' WHERE accound_id='".$_SESSION["id"]."'");
		die(json_encode(array("ok" => $lang->get("settings_safebox_reset"))));
	}else
		die(json_encode(array("error" => $lang->get("settings_pass_error"))));

}elseif(isset($_POST["changeemail"])){
	$plugin_conf=$ConfigProvider->get("plugin_settings");
	if (!isset($_POST["pass"]) || !isset($_POST["email"])) exit;
	if (empty($_POST["pass"]) || empty($_POST["email"]))
		die(json_encode(array("error" => $lang->get("fillout"))));
	if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})^", $_POST["email"])) 
           	die(json_encode(array("error" => $lang->get("register_email_error"))));
	$q=mysql_query("SELECT email FROM ".$db->gamedb["account"].".account WHERE id='".$_SESSION["id"]."' AND password=password('".mysql_real_escape_string($_POST["pass"])."')",$db->game);
	if (!mysql_num_rows($q)) 
		die(json_encode(array("error" => $lang->get("settings_pass_error"))));
	if ($plugin_conf->get("email_verify")){
		$res = mysql_fetch_object($q);
		$key1 = md5(microtime().uniqid());
		$key2 = md5(uniqid().microtime());
		if (isset($db->hp))
			mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.email_change VALUES("'.$_SESSION["id"].'","'.mysql_real_escape_string($_POST["email"]).'","'.$key1.'","'.$key2.'",0)',$db->hp);
		else
			mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.email_change VALUES("'.$_SESSION["id"].'","'.mysql_real_escape_string($_POST["email"]).'","'.$key1.'","'.$key2.'",0)',$db->game);
		mail($_POST["email"],$lang->get("settings_emailsubject",array("servername",$settings->get("name"))),$lang->get("settings_emailbody",array("url",$config["settings"]["baseurl"].$urlmap["register"].(!isUrl($urlmap["register"]) && substr($urlmap["register"],0,1) == "?"?"&":"?")."key2=".$key2,"username"=>$_SESSION["user"])),$config["settings"]["email_header"]);
		mail($res->email,$lang->get("settings_emailsubject",array("servername",$settings->get("name"))),$lang->get("settings_emailbody",array("url",$config["settings"]["baseurl"].$urlmap["register"].(!isUrl($urlmap["register"]) && substr($urlmap["register"],0,1) == "?"?"&":"?")."key1=".$key1,"username"=>$_SESSION["user"])),$config["settings"]["email_header"]);
		die(json_encode(array("ok" => $lang->get("settings_verifymailsent"))));
	}
	mysql_query('UPDATE '.$db->gamedb.'.account SET email="'.mysql_real_escape_string($_POST["email"]).'" WHERE id="'.$_SESSION["id"].'"',$db->game);
	die(json_encode(array("ok" => $lang->get("settings_email_changed"))));
}
?>