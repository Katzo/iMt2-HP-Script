<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called donate_psc
 * It helps you to make money with your server. (When you make enough money please consider donating to help me make more stuff like this!)
 * 
 */
include($config["path"]["includes"].$config["path"]["plugins"]."donate_psc/config.inc.php");
include($config["path"]["includes"].$config["path"]["plugins"]."donate_psc/psc.class.php");
if (!isset($_SESSION["user"]) || empty($_SESSION["user"]))
	$content = array(
		"head" => array(
			"title" => $lang["misc"]["needlogin"]
		),
		"middle" => array(
			"text" => $lang["misc"]["needlogin"]
		)
	);
elseif(isset($_POST["submit"]) && isset($_POST["code"]) && isset($_POST["captcha"])){
	if (empty($_POST["code"]) || empty($_POST["captcha"])){
		donate_psc_form($lang["misc"]["fillout"]);
	}else{
		$psc = new psc_cash_in;
		$psc->cookie=$psc->load_data('cookie');
	    $psc->cookie2=$psc->load_data('cookie2'); 
	    $psc->sessionid=$psc->load_data('sessionid');  
		$psc->code=mysql_real_escape_string($_POST["code"]);
		$psc->captcha=mysql_real_escape_string($_POST["captcha"]);
		$res = $psc->cash_in();
		if ($res == "ok"){
			if (isset($plugin_conf["currency"][$psc->currency])){
				$psc->value = $psc->value*$plugin_conf["currency"][$psc->currency];
				$boni=0;
				foreach($plugin_conf["boni"] as $cred => $bon) {
					if ($psc->value >= $cred && $bon > $boni)
						$boni = $bon;
				}
				$coins = $psc->value*$plugin_conf["rate"]+$boni;
				if (isset($db->hp))
					mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.psc (user,code,credit,coins,date) VALUES("'.$_SESSION["user"].'","'.$psc->code.'","'.$psc->value.'","'.$coins.'",NOW())',$db->hp);
				else
					mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.psc (user,code,credit,coins,date) VALUES("'.$_SESSION["user"].'","'.$psc->code.'","'.$psc->value.'","'.$coins.'",NOW())',$db->game);
				if (isset($db->hp) && mysql_affected_rows($db->hp) || !isset($db->hp) && mysql_affected_rows($db->game))
					$content = array(
						"head" => array(
							"title" => $lang["misc"]["donate"]
						),
						"middle" => array(
							"text" => $lang["donate_psc"]["success"]
						)
					);
				else
					donate_psc_form($lang["donate_psc"]["messages"]["error_unknown"]);
			}else
				donate_psc_form($lang["donate_psc"]["messages"]["error_noteuro"]);
		}else{
			donate_psc_form($lang["donate_psc"]["messages"][$res]);
		}
	}
}else{
	donate_psc_form();
}
function donate_psc_form($error = false){
	global $content;
	$psc = new psc_cash_in;
	$psc->session_laden(true);
	$psc->cookie=$psc->load_data('cookie');
    $psc->cookie2=$psc->load_data('cookie2'); 
    $psc->sessionid=$psc->load_data('sessionid');  
    $_SESSION["cookie"] = $psc->cookie;
    $_SESSION["cookie2"] = $psc->cookie2;
    $_SESSION["sessionid"] = $psc->sessionid;
	$captcha = $psc->show_captcha();
	if (!$captcha)
		$content = array(
			"head" => array(
				"title" => "Server Error"
			),
			"middle" => array(
				"text" => $lang["misc"]["servererrorcontact"]."<br/>Invalid psc response!"
			)
		);
	else{
		$content = array(
			"head" => array(
				"title" => $lang["misc"]["donate"]
			),
			"middle" => array(
				"text" => ($error?'<div class="error">'.$error.'</div>':'').'
						<form method="POST">
							<table>
								<tr><td>'.$lang["spenden_psc"]["code"].':</td><td><input type="text" name="code" placeholder="0000111122223333" maxlength="16"/></td></tr>
								<tr><td><img src="data:image/gif;base64,'.base64_encode($captcha).'" /></td><td><input type="text" name="captcha" placeholder="12345" maxlength="5"/></td></tr>
								<tr><td></td><td><input type="submit" class="btn" name="submit" value="'.$lang["misc"]["donate"].'"/></td></tr>
							</table>
						</form>'
			)
		);
	}
}
?>