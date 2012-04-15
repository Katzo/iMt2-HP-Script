<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called settings
 * It is basically a usercp where you can change your password and stuff.
 */
if (isset($_GET["key1"])) {
	if (strlen($_GET["key1"]) != 32)
		$content= array(
			"head" => array(
				"title" => $lang["settings"]["change_email"]
			),
			"middle" => array(
				"text" => $lang["reg"]["verify_error"]
			)
		);
	else{
		if (isset($db->hp))
			$q = mysql_query('SELECT id,email,status FROM '.$db->hpdb["homepage"].'.email_change WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->hp);
		else
			$q = mysql_query('SELECT id,email,status FROM '.$db->gamedb["homepage"].'.email_change WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->game);
		$res = mysql_fetch_object($q);
		if (!$res || $res->status == 1)
			$content= array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["reg"]["verify_error"]
				)
			);
		elseif ($res->status==0){
			if (isset($db->hp))
				mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=1 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->hp);
			else
				mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=1 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->game);
			$content= array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["settings"]["verify_otheremail"]
				)
			);	
		}elseif ($res->status==2){
			mysql_query('UPDATE '.$db->gamedb["account"].'.account SET email="'.$res->email.'" WHERE id="'.$res->id.'" LIMIT 1',$db->game);
			if (isset($db->hp))
				mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=3 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'"',$db->hp);
			else
				mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=3 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'"',$db->game);
			$content = array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["settings"]["email_changed"]
				)
			);
		}else 	
			$content= array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["reg"]["verify_error"]
				)
			);
		
	}
}elseif(isset($_GET["key2"])){
	if (strlen($_GET["key2"]) != 32)
		$content= array(
			"head" => array(
				"title" => $lang["settings"]["change_email"]
			),
			"middle" => array(
				"text" => $lang["reg"]["verify_error"]
			)
		);
	else{
		if (isset($db->hp))
			$q = mysql_query('SELECT id,email,status FROM '.$db->hpdb["homepage"].'.email_change WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'" LIMIT 1',$db->hp);
		else
			$q = mysql_query('SELECT id,email,status FROM '.$db->gamedb["homepage"].'.email_change WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'" LIMIT 1',$db->game);
		$res = mysql_fetch_object($q);
		if (!$res || $res->status == 2)
			$content= array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["reg"]["verify_error"]
				)
			);
		elseif ($res->status==0){
			if (isset($db->hp))
				mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=2 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->hp);
			else
				mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=2 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->game);
			$content= array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["settings"]["verify_otheremail"]
				)
			);	
		}elseif ($res->status==1){
			mysql_query('UPDATE '.$db->gamedb["account"].'.account SET email="'.$res->email.'" WHERE id="'.$_SESSION["id"].'" LIMIT 1',$db->game);
			if (isset($db->hp))
				mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=3 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->hp);
			else
				mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=3 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->game);
			$content = array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["settings"]["email_changed"]
				)
			);
		}else 	
			$content= array(
				"head" => array(
					"title" => $lang["settings"]["change_email"]
				),
				"middle" => array(
					"text" => $lang["reg"]["verify_error"]
				)
			);
		
	}
}elseif (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
	$content = array(
		"multi" => true,
		array(
			"head" => array(
				"title" => $lang["settings"]["change_password"]
			),
			"middle" => array(
				"text" => $lang["settings"]["change_password_text"].
						 '<div id="changepwres"></div>
						<form id="changepwform" onsubmit="javascript:ssubmit(\'#changepwform\',\'#changepwres\'); return false;">
							<table>
								<tr><td>'.$lang["misc"]["oldpass"].'</td><td><input class="bar" type="password" name="oldpass"></td></tr>
								<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td>'.$lang["misc"]["repeat"].'</td><td><input class="bar" type="password" name="repeat"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="changepw" value="'.$lang["misc"]["submit"].'"></td></tr>
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
						 '<div id="changecoderes"></div>
						<form id="changecodeform" onsubmit="javascript:ssubmit(\'#changecodeform\',\'#changecoderes\'); return false;">
							<table>
								<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td>'.$lang["misc"]["code"].'</td><td><input class="bar" type="text" name="code" maxlength="7"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="changecode" value="'.$lang["misc"]["submit"].'"></td></tr>
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
						 '<div id="changesafeboxres"></div>
						<form id="changesafeboxform" onsubmit="javascript:ssubmit(\'#changesafeboxform\',\'#changesafeboxres\'); return false;">
							<table>
								<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="resetsafebox" value="'.$lang["misc"]["submit"].'"></td></tr>
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
						 '<div id="changeemailres"></div>
						<form id="changeemailform" onsubmit="javascript:ssubmit(\'#changeemailform\',\'#changeemailres\'); return false;">
							<table>
								<tr><td>'.$lang["misc"]["pass"].'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td>'.$lang["misc"]["email"].'</td><td><input class="bar" type="name" name="email"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="changeemail" value="'.$lang["misc"]["submit"].'"></td></tr>
							</table>
						</form>'
			)
		),
		
	);
}
?>