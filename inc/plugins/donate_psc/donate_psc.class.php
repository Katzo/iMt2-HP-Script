<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called donate_psc
 * It allowes users to donate... via guess what! PSC! :D
 */
class plugin_donate_psc extends Plugin{
	private $meta = array(
		"information" => array(
			"name" => "Donate PSC",
			"version" => "1.0",
		),
		"requirements" => array(
			"mysql" => array(
				"hp" => array(
					"homepage" => array("psc")
				)
			)
		)
	);
	final private function form($error=false) {
		global $lang;
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
			throw new CException("Got an invalid response from Paysafecard.\nPlease try again and contact an admin if this problem persists.");
		else{
			$content = array(
				"head" => array(
					"title" => $lang->get("donate")
				),
				"middle" => array(
					"text" => ($error?'<div class="error">'.$error.'</div>':'').'
							<form method="POST">
								<table>
									<tr><td>'.$lang->get("psc_code_name").':</td><td><input class="bar" type="text" name="code" placeholder="0000111122223333" maxlength="16" onkeyup="$(this).val($(this).val().replace(/[^\d.]/g, \'\'));" /></td></tr>
									<tr><td><img src="data:image/gif;base64,'.base64_encode($captcha).'" /></td><td><input class="bar" type="text" name="captcha" placeholder="12345" maxlength="5"/></td></tr>
									<tr><td></td><td><input type="submit" class="btn" name="submit" value="'.$lang->get("donate").'"/></td></tr>
								</table>
							</form>'
				)
			);
		}
		return $content;
	}
	private function generate() {
		global $ConfigProvider,$config,$lang,$db;
		$plugin_conf=$ConfigProvider->get("plugin_donate_psc");
		if (!file_exists($config["path"]["includes"].$config["path"]["plugins"]."donate_psc/psc.class.php")) throw new CException("Could not find ".$config["path"]["includes"].$config["path"]["plugins"]."donate_psc/psc.class.php!");
		include($config["path"]["includes"].$config["path"]["plugins"]."donate_psc/psc.class.php");
		if (!isset($_SESSION["user"]) || empty($_SESSION["user"]))
			$this->add("content",array(
				"head" => array(
					"title" => $lang->get("donate")
				),
				"middle" => array(
					"text" => $lang->get("needlogin")
				)
			));
		elseif(isset($_POST["submit"]) && isset($_POST["code"]) && isset($_POST["captcha"])){
			if (empty($_POST["code"]) || empty($_POST["captcha"])){
				$this->add("content",$this->form($lang->get("fillout")));
			}else{
				$psc = new psc_cash_in;
				$psc->cookie=$psc->load_data('cookie');
			    $psc->cookie2=$psc->load_data('cookie2'); 
			    $psc->sessionid=$psc->load_data('sessionid');  
				$psc->code=mysql_real_escape_string($_POST["code"]);
				$psc->captcha=mysql_real_escape_string($_POST["captcha"]);
				$res = $psc->cash_in();
				if ($res == "ok"){
					if ($plugin_conf->get("currency",$psc->currency)){
						$psc->value = $psc->value*$plugin_conf->get("currency",$psc->currency);
						$boni=0;
						foreach($plugin_conf->get("boni") as $cred => $bon) {
							if ($psc->value >= $cred && $bon > $boni)
								$boni = $bon;
						}
						if ($psc->value < $plugin_conf->get("mincredit"))
							$this->add("content",$this->form($lang->get("psc_error_empty")));
						else{
							$coins = $psc->value*$plugin_conf->get("rate")+$boni;
							if (isset($db->hp))
								mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.psc (user,code,credit,coins,date) VALUES("'.$_SESSION["user"].'","'.$psc->code.'","'.$psc->value.'","'.$coins.'",NOW())',$db->hp);
							else
								mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.psc (user,code,credit,coins,date) VALUES("'.$_SESSION["user"].'","'.$psc->code.'","'.$psc->value.'","'.$coins.'",NOW())',$db->game);
							if (isset($db->hp) && mysql_affected_rows($db->hp) || !isset($db->hp) && mysql_affected_rows($db->game))
								$this->add("content",array(
									"head" => array(
										"title" => $lang->get("donate")
									),
									"middle" => array(
										"text" => $lang->get("psc_donate_success")
									)
								));
							else
								$this->add("content",$this->form($lang->get("psc_error_unknown")));
						}
					}else
						$this->add("content",$this->form($lang->get("psc_error_currency")));
				}else{
					$this->add("content",$this->form($lang->get("psc_".$res)));
				}
			}
		}else{
			$this->add("content",$this->form());
		}
	}
}
?>