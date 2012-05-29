<?php
class plugin_userpanel extends Plugin{
	private $meta=array(
		"information"=>array(
			"name"=>"Userpanel",
			"version"=>"1.0",
		)
	);
	private function generate(){
		global $ConfigProvider,$lang;
		$urlmap = $ConfigProvider->get("urlmap");
		$plugin_conf = $ConfigProvider->get("plugin_userpanel");
		
		if (isset($_SESSION["user"]) &&!empty($_SESSION["user"])) {
			$content = array(
				"head" => array(
					"title" => $lang->get("userpanel_title_loggedin"),
				),
				"middle" => array(
					"text" => $lang->get("userpanel_hello",array("username"=>$_SESSION["user"])).'<br/><br/>'.$lang->get("youcoin",array("coins"=>$_SESSION["coins"],"coinname"=>($_SESSION["coins"]==1)?$lang->get("coin"):$lang->get("coins"))).' <a href="'.$urlmap->get("donate").'">'.$lang->get("donate").'?</a><br/>
								<br/><div class="sb-sep"></div>
								<a class="sb-link" href="'.$urlmap->get("itemshop").'">'.$lang->get("itemshop").'</a>
								<a class="sb-link" href="'.$urlmap->get("settings").'">'.$lang->get("settings").'</a>
								<a class="sb-link" href="'.$urlmap->get("logout").'">'.$lang->get("logout").'</a>'
				),
			); 
		}else{
			// "Login" here.
			$content = array(
				"head" => array(
					"title" => $lang->get("userpanel_title_login"),
				),
				"middle" => array(
					"text" => '<div id="loginres"></div><form id="loginform" onsubmit="javascript:asubmit(\'#loginform\',\'ajax.php?p=dologin\',function (data){res = jQuery.parseJSON(data);if(res.error) $(\'#loginres\').addClass(\'error\').html(res.error); else if(res.ok) window.location.reload(); else $(\'#loginres\').addClass(\'error\').html(\'Unknown error!\');}); return false;">
									<input class="bar" type="text" name="user" placeholder="'.$lang->get("userpanel_user_placeholder").'" />
									<input class="bar" type="password" name="pass" placeholder="'.$lang->get("userpanel_password_placeholder").'" />
									<input class="btn left" type="submit" name="submit" value="'.$lang->get("login").'" />
									</form>
									<input class="btn right" onclick="location.href=\''.$urlmap->get("register").'\'" type="submit" name="register" value="'.$lang->get("register").'" />
									<div class="clear"></div>
								<div class="sb-sep"></div>
								<a class="sb-link" href="'.$urlmap->get("forgot_password").'">'.$lang->get("forgot_password").'?</a>'
				),
			); 
		}
		$this->add("jsfile","js/jquery.js");
		$this->add("jsfile","js/common.js");
		if ($plugin_conf->get("left"))
			$this->add("lside",$content);
		else
			$this->add("rside",$content);
	}
}
?>