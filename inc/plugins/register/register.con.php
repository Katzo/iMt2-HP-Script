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
if ($plugin_conf["enabled"]){
	if (isset($_POST["submit"])){
		// Reg here
	}else{
		$content = array(
			"head" => array(
				"title" => $lang["misc"]["register"],
			),
			"middle" => array(
				"text" => '<form method="POST"><table>
							<tr><td>'.$lang["misc"]["user"].'</td><td><inputclass="bar" type="text" placeholder="'.$lang["misc"]["user"].'" name="user" id="user" onblur="javascript:regcheck(\'user\');"/></td><td id="userres"></td></tr>
							<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["pass"].'" name="pass" id="pass" onblur="javascript:regcheck(\'pass\');"/></td><td id="passres"></td></tr>
							<tr><td>'.$lang["misc"]["repeat"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["repeat"].'" name="repeat" id="repeat" onblur="javascript:regcheck(\'repeat\');"/></td><td id="repeatres"></td></tr>
							<tr><td>'.$lang["misc"]["email"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["email"].'" name="repeat" id="repeat" onblur="javascript:regcheck(\'email\');"/></td><td id="emailres"></td></tr>
							<tr><td>'.$lang["misc"]["code"].'</td><td><input class="bar" type="text" placeholder="'.$lang["misc"]["code"].'" name="repeat" id="repeat" onblur="javascript:regcheck(\'email\');"/></td><td id="emailres"></td></tr>
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