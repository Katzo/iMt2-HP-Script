<?php
class plugin_settings extends Plugin{
	private $meta = array(
		"information"=>array(
			"name"=>"Settings",
			"version"=>"1.0 Beta"
		),
		"requirements"=>array(
			"plugins"=>array("register"),
			"mysql"=>array(
				"hp"=>array(
					"homepage"=>array("email_change")
				),
				"game"=>array(
					"account"=>array("account"),
					"player"=>array("safebox")
				)
			)
		)
	);
	private function key1(){
		global $db,$lang;
		if (strlen($_GET["key1"]) != 32)
			$this->add("content",array(
				"head" => array(
					"title" => $lang->get("settings_change_email")
				),
				"middle" => array(
					"text" => $lang->get("register_verify_error")
				)
			));
		else{
			if (isset($db->hp))
				$q = mysql_query('SELECT id,email,status FROM '.$db->hpdb["homepage"].'.email_change WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->hp);
			else
				$q = mysql_query('SELECT id,email,status FROM '.$db->gamedb["homepage"].'.email_change WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->game);
			$res = mysql_fetch_object($q);
			if (!$res || $res->status == 1)
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("register_verify_error")
					)
				));
			elseif ($res->status==0){
				if (isset($db->hp))
					mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=1 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->hp);
				else
					mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=1 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'" LIMIT 1',$db->game);
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("settings_verify_otheremail")
					)
				));	
			}elseif ($res->status==2){
				mysql_query('UPDATE '.$db->gamedb["account"].'.account SET email="'.$res->email.'" WHERE id="'.$res->id.'" LIMIT 1',$db->game);
				if (isset($db->hp))
					mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=3 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'"',$db->hp);
				else
					mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=3 WHERE key1="'.mysql_real_escape_string($_GET["key1"]).'"',$db->game);
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("settings_email_changed")
					)
				));
			}else 	
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("register_verify_error")
					)
				));
			
		}
	}
	private function key2(){
		global $lang,$db;
		if (strlen($_GET["key2"]) != 32)
			$this->add("content",array(
				"head" => array(
					"title" => $lang->get("settings_change_email")
				),
				"middle" => array(
					"text" => $lang->get("register_verify_error")
				)
			));
		else{
			if (isset($db->hp))
				$q = mysql_query('SELECT id,email,status FROM '.$db->hpdb["homepage"].'.email_change WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'" LIMIT 1',$db->hp);
			else
				$q = mysql_query('SELECT id,email,status FROM '.$db->gamedb["homepage"].'.email_change WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'" LIMIT 1',$db->game);
			$res = mysql_fetch_object($q);
			if (!$res || $res->status == 2)
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("register_verify_error")
					)
				));
			elseif ($res->status==0){
				if (isset($db->hp))
					mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=2 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->hp);
				else
					mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=2 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->game);
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("settings_verify_otheremail")
					)
				));	
			}elseif ($res->status==1){
				mysql_query('UPDATE '.$db->gamedb["account"].'.account SET email="'.$res->email.'" WHERE id="'.$_SESSION["id"].'" LIMIT 1',$db->game);
				if (isset($db->hp))
					mysql_query('UPDATE '.$db->hpdb["homepage"].'.email_change SET status=3 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->hp);
				else
					mysql_query('UPDATE '.$db->gamedb["homepage"].'.email_change SET status=3 WHERE key2="'.mysql_real_escape_string($_GET["key2"]).'"',$db->game);
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("settings_email_changed")
					)
				));
			}else 	
				$this->add("content",array(
					"head" => array(
						"title" => $lang->get("settings_change_email")
					),
					"middle" => array(
						"text" => $lang->get("register_verify_error")
					)
				));
			
		}
	}
	private function layout(){
		global $lang;
		$this->add("content",array(
			"head" => array(
				"title" => $lang->get("settings_change_password")
			),
			"middle" => array(
				"text" => $lang->get("settings_change_password_text").
						 '<div id="changepwres"></div>
						<form id="changepwform" onsubmit="javascript:ssubmit(\'#changepwform\',\'#changepwres\'); return false;">
							<table>
								<tr><td>'.$lang->get("settings_oldpass").'</td><td><input class="bar" type="password" name="oldpass"></td></tr>
								<tr><td>'.$lang->get("settings_pass").'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td>'.$lang->get("settings_repeat").'</td><td><input class="bar" type="password" name="repeat"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="changepw" value="'.$lang->get("settings_submit_change_pass").'"></td></tr>
							</table>
						</form>'
			)
		));
		$this->add("content",array(
			"head" => array(
				"title" => $lang->get("settings_change_code")
			),
			"middle" => array(
				"text" => $lang->get("settings_change_code_text").
						 '<div id="changecoderes"></div>
						<form id="changecodeform" onsubmit="javascript:ssubmit(\'#changecodeform\',\'#changecoderes\'); return false;">
							<table>
								<tr><td>'.$lang->get("settings_pass").'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td>'.$lang->get("settings_code").'</td><td><input class="bar" type="text" name="code" maxlength="7"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="changecode" value="'.$lang->get("settings_submit_change_code").'"></td></tr>
							</table>
						</form>'
			)
		));
		$this->add("content",array(
			"head" => array(
				"title" => $lang->get("settings_reset_safebox")
			),
			"middle" => array(
				"text" => $lang->get("settings_reset_safebox_text").
						 '<div id="changesafeboxres"></div>
						<form id="changesafeboxform" onsubmit="javascript:ssubmit(\'#changesafeboxform\',\'#changesafeboxres\'); return false;">
							<table>
								<tr><td>'.$lang->get("settings_pass").'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="resetsafebox" value="'.$lang->get("settings_submit_reset_safebox").'"></td></tr>
							</table>
						</form>'
			)
		));
		$this->add("content",array(
			"head" => array(
				"title" => $lang->get("settings_change_email")
			),
			"middle" => array(
				"text" => $lang->get("settings_change_email_text").
						 '<div id="changeemailres"></div>
						<form id="changeemailform" onsubmit="javascript:ssubmit(\'#changeemailform\',\'#changeemailres\'); return false;">
							<table>
								<tr><td>'.$lang->get("settings_pass").'</td><td><input class="bar" type="password" name="pass"></td></tr>
								<tr><td>'.$lang->get("settings_email").'</td><td><input class="bar" type="name" name="email"></td></tr>
								<tr><td></td><td><input class="btn" type="submit" name="changeemail" value="'.$lang->get("settings_submit_change_email").'"></td></tr>
							</table>
						</form>'
			)
		));
	}
	private function generate(){
		if (isset($_GET["key1"])) 
			$this->key1();
		elseif(isset($_GET["key2"]))
			$this->key2();
		elseif (isset($_SESSION["user"]) && !empty($_SESSION["user"])) 
			$this->layout();
		else{
			global $lang;
			$this->add("content",array(
				"head" => array(
					"title" => $lang->get("needlogin")
				),
				"middle" => array(
					"text" => $lang->get("needlogin")
				)
			));
		}
		$this->add("jsfile","js/jquery.js");
		$this->add("jsfile","js/common.js");
		$this->add("js","function ssubmit(what,rese){
			asubmit(what,'ajax.php?p=settings',function (data){res =jQuery.parseJSON(data);if(res.error) $(rese).removeClass('ok').addClass('error').html(res.error); else if(res.ok) $(rese).removeClass('error').addClass('ok').html(res.ok); else $(rese).addClass('error').html('Unknown error! HELP!');});
		}");
	}
}
?>