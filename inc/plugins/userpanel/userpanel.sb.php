<?php
include($config["path"]["includes"].$config["path"]["plugins"]."userpanel/config.inc.php");
if (isset($_SESSION["user"]) &&!empty($_SESSION["user"])) {
		$content = array(
		"head" => array(
			"title" => $plugin_conf["title_loggedin"],
		),
		"middle" => array(
			"text" => str_replace("%username",$_SESSION["user"],$lang["misc"]["hello"]).'<br/>'.str_replace("%coinname",$lang["misc"]["coins"],str_replace("%coins",$_SESSION["coins"],$lang["misc"]["youcoin"])).'<a href="'.$urlmap["donate"].'">'.$lang["misc"]["donate"].'</a><br/><div class="sep"></div>
						<a class="sb-link" href="'.$urlmap["char"].'">'.$lang["misc"]["char"].'</a>
						<a class="sb-link" href="'.$urlmap["itemshop"].'">'.$lang["misc"]["itemshop"].'</a>
						<a class="sb-link" href="'.$urlmap["settings"].'">'.$lang["misc"]["settings"].'</a>'
		),
	); 
}else{
	// "Login" here.
	$content = array(
		"head" => array(
			"title" => $plugin_conf["title_login"],
		),
		"middle" => array(
			"text" => '<div id="loginres"></div><form id="loginform" onsubmit="javascript:asubmit(\'#loginform\',\'ajax.php?p=dologin\',function (data){res = jQuery.parseJSON(data);if(res.error) $(\'#loginres\').addClass(\'error\').html(res.error); else if(res.ok) window.location.reload(); else $(\'#loginres\').addClass(\'error\').html(\'Unknown error!\');}); return false;">
							<input class="bar" type="text" name="user" placeholder="'.$lang["misc"]["user"].'" />
							<input class="bar" type="password" name="pass" placeholder="'.$lang["misc"]["pass"].'" />
							<input class="btn left" type="submit" name="submit" value="'.$lang["misc"]["login"].'" />
							</form><form method="link" action="'.$plugin_conf["register_link"].'">
							<input class="btn right" type="submit" name="register" value="'.$lang["misc"]["register"].'" />
							<div class="clear"></div></form>
						<div class="sb-sep"></div>
						<a class="sb-link" href="'.$urlmap["forgot_password"].'">'.$lang["misc"]["forgot"].'</a>
						<a class="sb-link" href="'.$urlmap["support"].'">'.$lang["misc"]["support"].'</a>'
		),
	); 
}


?>