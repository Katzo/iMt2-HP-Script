<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "register"
 * guess what it does.
 */
include($config["path"]["includes"].$config["path"]["plugins"]."register/config.inc.php");
if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
	$content = array(
		"head" => array(
			"title" => $lang["misc"]["register"],
		),
		"middle" => array(
			"text" => $lang["reg"]["register_loggedin"],
		)
	);
}elseif (isset($_GET["key"])) {
	if (strlen($_GET["key"]) == 32){
		if (isset($db->hp))
			$q = mysql_query('SELECT id FROM '.$db->hpdb["homepage"].'.email_verify WHERE `key`="'.mysql_real_escape_string($_GET["key"]).'"',$db->hp);
		else
			$q = mysql_query('SELECT id FROM '.$db->gamedb["homepage"].'.email_verify WHERE `key`="'.mysql_real_escape_string($_GET["key"]).'"',$db->game);
		echo mysql_error();
		$res = mysql_fetch_object($q);
		if (!$res) {
			$content = array(
				"head" => array(
					"title" => $lang["misc"]["register"],
				),
				"middle" => array(
					"text" => $lang["reg"]["verify_error"]
				) 
			);
		}else{
			mysql_query('UPDATE '.$db->gamedb["account"].'.account SET status="OK" WHERE id="'.$res->id.'" and status="EMAIL"',$db->game);
			if (mysql_affected_rows($db->game)) 
				$content = array(
					"head" => array(
						"title" => $lang["misc"]["register"],
					),
					"middle" => array(
						"text" => $lang["reg"]["verify_success"]
					) 
				);
			else
				$content = array(
					"head" => array(
						"title" => $lang["misc"]["register"],
					),
					"middle" => array(
						"text" => $lang["reg"]["verify_error"]
					) 
				);
		}
	} 
	
	
}elseif ($plugin_conf["enabled"]){
	if (is_array($plugin_conf["captcha"])) include($config["path"]["includes"]."recaptchalib.php");
	if (isset($_POST["submit"])){
		
		if (isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["repeat"]) && isset($_POST["email"]) && isset($_POST["code"]) && (!is_array($plugin_conf["captcha"]) || isset($_POST["recaptcha_response_field"]))) {
			$regerror="";
			if (is_array($plugin_conf["captcha"])){
				$captcha_check = recaptcha_check_answer ($plugin_conf["captcha"]["private_key"],
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
                if (!$captcha_check->is_valid) $regerror .= $lang["reg"]["captcha_error"]."<br/>";
            }
            if ((empty($_POST["user"]) || empty($_POST["pass"]) || empty($_POST["repeat"]) || empty($_POST["email"]) || empty($_POST["code"]))) 
            	$regerror .= $lang["misc"]["fillout"]."<br/>";
            if (!($_POST["pass"] === $_POST["repeat"]))
            	$regerror .= $lang["reg"]["passrepeat_error"]."<br/>";
            if (strlen($_POST["user"]) < $plugin_conf["minuserlen"])
            	$regerror .= str_replace("%len",$plugin_conf["minuserlen"],$lang["reg"]["userminlen_error"])."<br/>";
            if (strlen($_POST["user"]) > $plugin_conf["maxuserlen"])
            	$regerror .= str_replace("%len",$plugin_conf["maxuserlen"],$lang["reg"]["usermaxlen_error"])."<br/>";
            if (strlen($_POST["pass"]) < $plugin_conf["minpasslen"])
            	$regerror .= str_replace("%len",$plugin_conf["minpasslen"],$lang["reg"]["passminlen_error"])."<br/>";
            if (strlen($_POST["pass"]) > $plugin_conf["maxpasslen"])
            	$regerror .= str_replace("%len",$plugin_conf["maxpasslen"],$lang["reg"]["passmaxlen_error"])."<br/>";
            if (strlen($_POST["code"]) != 7)
            	$regerror .= $lang["reg"]["codelen_error"]."<br/>";
            if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})^", $_POST["email"])) 
            	$regerror .= $lang["reg"]["email_error"]."<br/>";
			$q = mysql_query('SELECT id FROM '.$db->gamedb["account"].'.account WHERE login="'.mysql_real_escape_string($_POST["user"]).'" LIMIT 1',$db->game);	
			if (mysql_num_rows($q))
				$regerror .=$lang["reg"]["account_exists"]."<br/>";
			if (!$plugin_conf["multiemail"]){
				$q = mysql_query('SELECT id FROM '.$db->gamedb["account"].'.account WHERE email="'.mysql_real_escape_string($_POST["email"]).'"');
				echo mysql_error();
				if (mysql_num_rows($q)) 
					$regerror .=$lang["reg"]["multiacc_error"]."<br/>";				
			}
			
			if ($regerror == ""){
				$qstrboni = "";
				$qstrbonival = "";
				foreach ($plugin_conf["itemshop_boni"] as $what_boni => $len_boni){
					$qstrboni = ",".$what_boni;
					$qstrbonival = ",DATE_ADD(NOW(),INTERVAL ".$len_boni." DAY)";
				}	
				if ($plugin_conf["verifyemail"]){
					$key= md5(microtime().uniqid());

					mysql_query('INSERT INTO '.$db->gamedb["account"].'.account (login,password,social_id,email,status'.$qstrboni.') VALUES("'.mysql_real_escape_string($_POST["user"]).'",PASSWORD("'.mysql_real_escape_string($_POST["pass"]).'"),"'.mysql_real_escape_string($_POST["code"]).'","'.mysql_real_escape_string($_POST["email"]).'","EMAIL"'.$qstrbonival.')',$db->game);
					echo mysql_error();
					if (isset($db->hp)) 
						mysql_query('INSERT INTO '.$db->hpdb["homepage"].'.email_verify VALUES("'.mysql_insert_id().'","'.$key.'")',$db->hp);
					else
						mysql_query('INSERT INTO '.$db->gamedb["homepage"].'.email_verify VALUES("'.mysql_insert_id().'","'.$key.'")',$db->game);
					mail($_POST["email"],str_replace("%username",$_POST["user"],$lang["reg"]["emailsubject"]),str_replace("%key",$key,str_replace("%username",$_POST["user"],$lang["reg"]["emailbody"])),$config["settings"]["email_header"]);
					$content = array(
						"head" => array(
							"title" => $lang["misc"]["register"],
						),
						"middle" => array(
							"text" => $lang["reg"]["success_emailverify"]
						)
					);
				}else{
					mysql_query('INSERT INTO '.$db->gamedb["account"].'.account (login,password,social_id,email'.$qstrboni.') VALUES("'.mysql_real_escape_string($_POST["user"]).'",PASSWORD("'.mysql_real_escape_string($_POST["pass"]).'"),"'.mysql_real_escape_string($_POST["code"]).'","'.mysql_real_escape_string($_POST["email"]).'",'.$qstrbonival.')',$db->game);
					$content = array(
						"head" => array(
							"title" => $lang["misc"]["register"],
						),
						"middle" => array(
							"text" => $lang["reg"]["success"],
						)
					);
				}
			}
		}
	}
	if (!isset($_POST["submit"]) || (isset($regerror) && $regerror != "")){
		$content = array(
			"head" => array(
				"title" => $lang["misc"]["register"],
			),
			"middle" => array(
				"text" => ((isset($regerror))?'<font class="error">'.$regerror.'</font>':'').'<form method="POST"><table style="width:90%;">
							<tr><td>'.$lang["misc"]["user"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["user"].'" name="user" id="user" onblur="javascript:regcheck(\'user\');" '.((isset($_POST["user"]))?'value="'.$_POST["user"].'" ':'').'/></td><td id="userres"></td></tr>
							<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="password" placeholder="'.$lang["misc"]["pass"].'" name="pass" id="pass" onblur="javascript:regcheck(\'pass\');" /></td><td id="passres"></td></tr>
							<tr><td>'.$lang["misc"]["repeat"].'</td><td><input class="bar" type="password" placeholder="'.$lang["misc"]["repeat"].'" name="repeat" id="repeat" onblur="if ($(this).val() !=$(\'#pass\').val()) $(\'#repeatres\').addClass(\'error\').html(\''.$lang["reg"]["passrepeat_error"].'\')" /></td><td id="repeatres"></td></tr>
							<tr><td>'.$lang["misc"]["email"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["email"].'" name="email" id="email" onblur="javascript:regcheck(\'email\');" '.((isset($_POST["email"]))?'value="'.$_POST["email"].'" ':'').'/></td><td id="emailres"></td></tr>
							<tr><td>'.$lang["misc"]["code"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["code"].'" name="code" id="code" onblur="javascript:regcheck(\'code\');" '.((isset($_POST["code"]))?'value="'.$_POST["code"].'" ':'').'/></td><td id="coderes"></td></tr>
							'.((is_array($plugin_conf["captcha"]))?'<tr><td colspan="3">'.recaptcha_get_html($plugin_conf["captcha"]["public_key"]).'</td></tr>':'').'
							<tr><td></td><td><input class="btn" type="submit" name="submit" value="'.$lang["misc"]["submit"].'"/></td><td></td>
						</table></form>',
			)
		);
	}
}else
	$content = array(
		"head" => array(
			"title" => $lang["misc"]["register"],
		),
		"middle" => array(
			"text" => $lang["reg"]["register_closed"],
		)
	);
unset($plugin_conf);
?>