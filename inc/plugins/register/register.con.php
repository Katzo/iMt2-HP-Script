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
// Note to self: https://developers.google.com/recaptcha/docs/php for captcha

if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
	$content = array(
		"head" => array(
			"title" => $lang["misc"]["register"],
		),
		"middle" => array(
			"text" => $lang["misc"]["register_loggedin"],
		)
	);
}elseif ($plugin_conf["enabled"]){
	if (is_array($plugin_conf["captcha"])) include($config["path"]["includes"]."recaptchalib.php");
	if (isset($_POST["submit"])){
		if (isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["repeat"]) && isset($_POST["email"]) && isset($_POST["code"]) && (!is_array($plugin_conf["captcha"]) || isset($_POST["recaptcha_response_field"]))) {
			if (is_array($plugin_conf["captcha"])){
				$captcha_check = recaptcha_check_answer ($plugin_conf["captcha"]["private_key"],
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
                if (!$captcha_check->is_valid) $regerror = $lang["misc"]["captcha_error"];
            }
				
		}
	}
	if (!isset($_POST["submit"]) || isset($regerror)){
		$content = array(
			"head" => array(
				"title" => $lang["misc"]["register"],
			),
			"middle" => array(
				"text" => ((isset($regerror))?'<font class="error">'.$regerror.'</font>':'').'<form method="POST"><table>
							<tr><td>'.$lang["misc"]["user"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["user"].'" name="user" id="user" onblur="javascript:regcheck(\'user\');" '.((isset($_POST["user"]))?'value="'.$_POST["user"].'" ':'').'/></td><td id="userres"></td></tr>
							<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["pass"].'" name="pass" id="pass" onblur="javascript:regcheck(\'pass\');" /></td><td id="passres"></td></tr>
							<tr><td>'.$lang["misc"]["repeat"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["repeat"].'" name="repeat" id="repeat" onblur="if ($(this).val() !=$(\'#pass\').val()) $(\'#repeatres\').addClass(\'error\').html(\'\')" /></td><td id="repeatres"></td></tr>
							<tr><td>'.$lang["misc"]["email"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["email"].'" name="email" id="email" onblur="javascript:regcheck(\'email\');" '.((isset($_POST["email"]))?'value="'.$_POST["email"].'" ':'').'/></td><td id="emailres"></td></tr>
							<tr><td>'.$lang["misc"]["code"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["code"].'" name="code" id="code" onblur="javascript:regcheck(\'code\');" '.((isset($_POST["code"]))?'value="'.$_POST["code"].'" ':'').'/></td><td id="emailres"></td></tr>
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
			"text" => $lang["misc"]["register_closed"],
		)
	);
unset($plugin_conf);
?>