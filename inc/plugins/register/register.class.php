<?php
class plugin_register extends Plugin{
	private $meta=array(
		"information" => array(
			"name"=>"Register",
			"version"=>"1.0"
		),
		"requirements"=>array(
			"mysql"=>array(
				"hp"=>array(
					"homepage"=>array("security_question")
				),
				"game"=>array(
					"account"=>array("account")
				)
			)
		)
	);
	private function loggedin() {
		global $lang;
		$this->add("content",array(
				"head" => array(
					"title" => $lang->get("register"),
				),
				"middle" => array(
					"text" => $lang->get("register_loggedin"),
				)
			));
	}
	private function key(){
		global $db,$lang;
		if (strlen($_GET["key"]) == 32){
			if (isset($db->hp))
				$q = mysql_query('SELECT id FROM '.$db->hpdb["homepage"].'.email_verify WHERE `key`="'.mysql_real_escape_string($_GET["key"]).'"',$db->hp);
			else
				$q = mysql_query('SELECT id FROM '.$db->gamedb["homepage"].'.email_verify WHERE `key`="'.mysql_real_escape_string($_GET["key"]).'"',$db->game);
			$res = mysql_fetch_object($q);
			if (!$res) {
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("register"),
					),
					"middle" => array(
						"text" => $lang->get("register_verify_error")
					) 
				));
			}else{
				mysql_query('UPDATE '.$db->gamedb["account"].'.account SET status="OK" WHERE id="'.$res->id.'" and status="EMAIL"',$db->game);
				if (mysql_affected_rows($db->game)) 
					$this->add("content",array(
						"head" => array(
							"title" => $lang->get("register")
						),
						"middle" => array(
							"text" => $lang->get("register_verify_success")
						) 
					));
				else
					$this->add("content",array(
						"head" => array(
							"title" => $lang->get("register")
						),
						"middle" => array(
							"text" => $lang->get("register_verify_error")
						) 
					));
			}
		} 
	}
	private function reg(){
		global $db,$lang,$ConfigProvider,$config;
		$plugin_conf=$ConfigProvider->get("plugin_register");
		$settings=$ConfigProvider->get("settings");
		$urlmap=$ConfigProvider->get("urlmap");
		if (is_array($plugin_conf->get("captcha"))){
			if (!file_exists($config["path"]["includes"].$config["path"]["plugins"]."register/recaptchalib.php")) throw new CException("Recaptchalib.php does not exist. Required by register plugin.\nDisable captcha verification or download it from somewhere!");
			include($config["path"]["includes"].$config["path"]["plugins"]."register/recaptchalib.php");
		}
		if (isset($_POST["submit"])){
			
			if (isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["repeat"]) && isset($_POST["email"]) && isset($_POST["code"]) && isset($_POST["security_question"]) && isset($_POST["security_answer"]) && (!is_array($plugin_conf->get("captcha")) || isset($_POST["recaptcha_response_field"]))) {
				$regerror="";
				if (is_array($plugin_conf->get("captcha"))){
					$captcha_check = recaptcha_check_answer ($plugin_conf->get("captcha","private_key"),
											   $_SERVER["REMOTE_ADDR"],
											   $_POST["recaptcha_challenge_field"],
											   $_POST["recaptcha_response_field"]);
					   if (!$captcha_check->is_valid) $regerror .= $lang->get("register_captcha_error")."<br/>";
				}
				if ((empty($_POST["user"]) || empty($_POST["pass"]) || empty($_POST["repeat"]) || empty($_POST["email"]) || empty($_POST["code"]))) 
				 	$regerror .= $lang->get("fillout")."<br/>";
				if (!($_POST["pass"] === $_POST["repeat"]))
				 	$regerror .= $lang->get("register_passrepeat_error")."<br/>";
				if (strlen($_POST["user"]) < $plugin_conf->get("minuserlen"))
					$regerror .= $lang->get("register_userminlen_error",array("len"=>$plugin_conf->get("minuserlen")))."<br/>";
				if (strlen($_POST["user"]) > $plugin_conf->get("maxuserlen"))
					$regerror .= $lang->get("register_usermaxlen_error",array("len"=>$plugin_conf->get("maxuserlen")))."<br/>";
				if (strlen($_POST["pass"]) < $plugin_conf->get("minpasslen"))
					$regerror .= $lang->get("register_passminlen_error",array("len"=>$plugin_conf->get("minpasslen")))."<br/>";
				if (strlen($_POST["pass"]) > $plugin_conf->get("maxpasslen"))
					$regerror .= $lang->get("register_passmaxlen_error",array("len"=>$plugin_conf->get("maxpasslen")))."<br/>";
				if (strlen($_POST["security_question"]) < $plugin_conf->get("minsecqlen"))
					$regerror .= $lang->get("register_secqminlen_error",array("len"=>$plugin_conf->get("minsecqlen")))."<br/>";
				if (strlen($_POST["security_question"]) > $plugin_conf->get("maxsecqlen"))
					$regerror .= $lang->get("register_secqmaxlen_error",array("len"=>$plugin_conf->get("maxsecqlen")))."<br/>";
				if (strlen($_POST["security_answer"]) < $plugin_conf->get("minsecalen"))
					$regerror .= $lang->get("register_secaminlen_error",array("len"=>$plugin_conf->get("minsecalen")))."<br/>";
				if (strlen($_POST["security_answer"]) > $plugin_conf->get("maxsecalen"))
					$regerror .= $lang->get("register_secamaxlen_error",array("len",$plugin_conf->get("maxsecalen")))."<br/>";
				if (strlen($_POST["code"]) != 7)
					$regerror .= $lang->get("register_codelen_error")."<br/>";
				if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})^", $_POST["email"])) 
					$regerror .= $lang->get("register_email_error")."<br/>";
				$q = mysql_query('SELECT id FROM '.$db->gamedb["account"].'.account WHERE login="'.mysql_real_escape_string($_POST["user"]).'" LIMIT 1',$db->game);	
				if (mysql_num_rows($q))
					$regerror .=$lang->get("register_account_exists")."<br/>";
				if (!$plugin_conf->get("multiemail")){
					$q = mysql_query('SELECT id FROM '.$db->gamedb["account"].'.account WHERE email="'.mysql_real_escape_string($_POST["email"]).'"');
					echo mysql_error();
					if (mysql_num_rows($q)) 
						$regerror .=$lang->get("register_multiacc_error")."<br/>";				
				}
				
				if ($regerror == ""){
					$qstrboni = "";
					$qstrbonival = "";
					foreach ($plugin_conf->get("itemshop_boni") as $what_boni => $len_boni){
						$qstrboni .= ",".$what_boni;
						$qstrbonival .= ",DATE_ADD(NOW(),INTERVAL ".$len_boni." DAY)";
					}	
					if ($plugin_conf->get("verifyemail")){
						$key= md5(microtime().uniqid());
						mysql_query('INSERT INTO '.$db->gamedb["account"].'.account (login,password,social_id,email,status'.$qstrboni.') VALUES("'.mysql_real_escape_string($_POST["user"]).'",PASSWORD("'.mysql_real_escape_string($_POST["pass"]).'"),"'.mysql_real_escape_string($_POST["code"]).'","'.mysql_real_escape_string($_POST["email"]).'","EMAIL"'.$qstrbonival.')',$db->game);
						$uid = mysql_insert_id($db->game);
						if (isset($db->hp)) 
							mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.security_question VALUES("'.$uid.'","'.mysql_real_escape_string($_POST["security_question"]).'","'.mysql_real_escape_string($_POST["security_answer"]).'")',$db->hp);
						else
							mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.security_question VALUES("'.$uid.'","'.mysql_real_escape_string($_POST["security_question"]).'","'.mysql_real_escape_string($_POST["security_answer"]).'")',$db->game);
						if (isset($db->hp)) 
							mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.email_verify VALUES("'.$uid.'","'.$key.'")',$db->hp);
						else
							mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.email_verify VALUES("'.$uid.'","'.$key.'")',$db->game);
						mail($_POST["email"],$lang->get("register_email_subject",array("username"=>$_POST["user"])),$lang->get("register_email_body",array("username"=>$_POST["user"],"url"=>$settings->get("baseurl").$urlmap->get("register").(!isUrl($urlmap->get("register")) && substr($urlmap->get("register"),0,1) == "?"?"&":"?")."key=".$key)),$settings->get("email_header"));
						$this->add("content",array(
							"head" => array(
								"title" => $lang->get("register"),
							),
							"middle" => array(
								"text" => $lang->get("register_success_emailverify")
							)
						));
					}else{
						mysql_query('INSERT INTO '.$db->gamedb["account"].'.account (login,password,social_id,email,status'.$qstrboni.') VALUES("'.mysql_real_escape_string($_POST["user"]).'",PASSWORD("'.mysql_real_escape_string($_POST["pass"]).'"),"'.mysql_real_escape_string($_POST["code"]).'","'.mysql_real_escape_string($_POST["email"]).'","OK"'.$qstrbonival.')',$db->game);
						$uid = mysql_insert_id($db->game);
						if (isset($db->hp)) 
							mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.security_question VALUES("'.$uid.'","'.mysql_real_escape_string($_POST["security_question"]).'","'.mysql_real_escape_string($_POST["security_answer"]).'")',$db->hp);
						else
							mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.security_question VALUES("'.$uid.'","'.mysql_real_escape_string($_POST["security_question"]).'","'.mysql_real_escape_string($_POST["security_answer"]).'")',$db->game);
		
						$this->add("content",array(
							"head" => array(
								"title" => $lang["misc"]["register"],
							),
							"middle" => array(
								"text" => $lang["reg"]["success"],
							)
						));
					}
				}
			}
		}
		if (!isset($_POST["submit"]) || (isset($regerror) && $regerror != "")){
			$this->add("content",array(
				"head" => array(
					"title" => $lang->get("register"),
				),
				"middle" => array(
					"text" => ((isset($regerror))?'<font class="error">'.$regerror.'</font>':'').'<form method="POST"><table style="width:90%;">
								<tr><td>'.$lang->get("register_user").'</td><td><input class="bar" type="text" placeholder="'.$lang->get("register_user").'" name="user" id="user" onblur="javascript:regcheck(\'user\');" '.((isset($_POST["user"]))?'value="'.$_POST["user"].'" ':'').'/></td><td id="userres"></td></tr>
								<tr><td>'.$lang->get("register_pass").'</td><td><input class="bar" type="password" placeholder="'.$lang->get("register_pass").'" name="pass" id="pass" onblur="javascript:regcheck(\'pass\');" /></td><td id="passres"></td></tr>
								<tr><td>'.$lang->get("register_repeat").'</td><td><input class="bar" type="password" placeholder="'.$lang->get("register_repeat").'" name="repeat" id="repeat" onblur="if ($(this).val() !=$(\'#pass\').val()) $(\'#repeatres\').addClass(\'error\').html(\''.$lang->get("register_passrepeat_error").'\')" /></td><td id="repeatres"></td></tr>
								<tr><td>'.$lang->get("register_email").'</td><td><input class="bar" type="text" placeholder="'.$lang->get("register_email").'" name="email" id="email" onblur="javascript:regcheck(\'email\');" '.((isset($_POST["email"]))?'value="'.$_POST["email"].'" ':'').'/></td><td id="emailres"></td></tr>
								<tr><td>'.$lang->get("register_code").'</td><td><input class="bar" type="text" placeholder="'.$lang->get("register_code").'" name="code" id="code" onblur="javascript:regcheck(\'code\');" '.((isset($_POST["code"]))?'value="'.$_POST["code"].'" ':'').'/></td><td id="coderes"></td></tr>
								<tr><td>'.$lang->get("register_security_question").'</td><td><input class="bar" type="text" placeholder="'.$lang->get("register_security_question").'" name="security_question" id="security_question" onblur="javascript:regcheck(\'security_question\');" '.((isset($_POST["security_question"]))?'value="'.$_POST["security_question"].'" ':'').'/></td><td id="security_questionres"></td></tr>
								<tr><td>'.$lang->get("register_security_answer").'</td><td><input class="bar" type="text" placeholder="'.$lang->get("register_security_answer").'" name="security_answer" id="security_answer" onblur="javascript:regcheck(\'security_answer\');" '.((isset($_POST["security_answer"]))?'value="'.$_POST["security_answer"].'" ':'').'/></td><td id="security_answerres"></td></tr>
								'.((is_array($plugin_conf->get("captcha")))?'<tr><td colspan="3">'.recaptcha_get_html($plugin_conf->get("captcha","public_key")).'</td></tr>':'').'
								<tr><td></td><td><input class="btn" type="submit" name="submit" value="'.$lang->get("register_submit").'"/></td><td></td>
							</table></form>',
				)
			));
		}
	}
	private function generate(){
		global $ConfigProvider,$lang;
		$plugin_conf=$ConfigProvider->get("plugin_register");
		if (isset($_SESSION["user"]) && !empty($_SESSION["user"]))
			$this->loggedin(); 
		elseif (isset($_GET["key"])) 
			$this->key();
		elseif ($plugin_conf->get("enabled")){
			$this->reg();
		}else
			$this->add("content",array(
				"head" => array(
					"title" => $lang->get("register")
				),
				"middle" => array(
					"text" => $lang->get("register_closed")
				)
			));
	}
}