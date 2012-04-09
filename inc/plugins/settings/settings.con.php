<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called settings
 * It is basically a usercp where you can change your password and stuff.
 */
if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
	$content = array(
		"multi" => true,
		array(
			"head" => array(
				"title" => $lang["settings"]["change_password"]
			),
			"middle" => array(
				"text" => $lang["settings"]["change_password_text"].
						 '<br/><div id="changepwres"></div>
						<form id="changepwform" onsubmit="javascript:ssubmit(\'#changepwform\',\'#changepwres\'); return false;">
							<table>
								<tr>'.$lang["misc"]["oldpass"].'<td></td><td><input type="password" name="oldpass"></td></tr>
								<tr>'.$lang["misc"]["pass"].'<td></td><td><input type="password" name="pass"></td></tr>
								<tr>'.$lang["misc"]["repeat"].'<td></td><td><input type="password" name="repeat"></td></tr>
								<tr><td></td><td><input type="submit" name="changepw" value="'.$lang["misc"]["submit"].'"></td></tr>
							</table>
						</form>'
			)
		),
		array(
			"head" => array(
				"title" => $lang["settings"]["change_code"]
			),
			"middle" => array(
				"text" => $lang["settings"]["change_code_text"].
						 '<br/><div id="changecoderes"></div>
						<form id="changecodeform" onsubmit="javascript:ssubmit(\'#changecodeform\',\'#changecoderes\'); return false;">
							<table>
								<tr>'.$lang["misc"]["pass"].'<td></td><td><input type="password" name="pass"></td></tr>
								<tr>'.$lang["misc"]["code"].'<td></td><td><input type="password" name="code"></td></tr>
								<tr><td></td><td><input type="submit" name="changecode" value="'.$lang["misc"]["submit"].'"></td></tr>
							</table>
						</form>'
			)
		),
		array(
			"head" => array(
				"title" => $lang["settings"]["reset_safebox"]
			),
			"middle" => array(
				"text" => $lang["settings"]["reset_safebox_text"].
						 '<br/><div id="changesafeboxres"></div>
						<form id="changesafeboxform" onsubmit="javascript:ssubmit(\'#changesafeboxform\',\'#changesafeboxres\'); return false;">
							<table>
								<tr>'.$lang["misc"]["pass"].'<td></td><td><input type="password" name="pass"></td></tr>
								<tr><td></td><td><input type="submit" name="resetsafebox" value="'.$lang["misc"]["submit"].'"></td></tr>
							</table>
						</form>'
			)
		),
		array(
			"head" => array(
				"title" => $lang["settings"]["change_email"]
			),
			"middle" => array(
				"text" => $lang["settings"]["change_email_text"].
						 '<br/><div id="changeemailres"></div>
						<form id="changeemailform" onsubmit="javascript:ssubmit(\'#changeemailform\',\'#changeemailres\'); return false;">
							<table>
								<tr>'.$lang["misc"]["pass"].'<td></td><td><input type="password" name="pass"></td></tr>
								<tr>'.$lang["misc"]["email"].'<td></td><td><input type="name" name="email"></td></tr>
								<tr><td></td><td><input type="submit" name="changeemail" value="'.$lang["misc"]["submit"].'"></td></tr>
							</table>
						</form>'
			)
		),
		
	);
}
?>