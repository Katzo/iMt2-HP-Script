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
							<tr><td>'.$lang["misc"]["user"].'</td><td><input type="text" placeholder="'.$lang["misc"]["user"].'"/></td><td id="ures"></td></tr>
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