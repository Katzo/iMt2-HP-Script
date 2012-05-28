<?php
class plugin_online_status extends Plugin{
	private $meta=array(
		"information" => array(
			"name"=>"Online Status",
			"version"=>"1.0"
		),
		"requirements" => array(
			"mysql" => array(
				"hp" => array(
					"homepage"=>array("online_status")
				)
			)
		),
	);
	private function generate(){
		global $db,$ConfigProvider,$lang;
		$plugin_conf=$ConfigProvider->get("plugin_online_status");
		if (isset($db->hp)) 
			$cachedq = mysql_query("SELECT * FROM ".$db->hpdb["homepage"].".online_status ORDER BY time DESC LIMIT 1",$db->hp);
		else
			$cachedq = mysql_query("SELECT * FROM ".$db->gamedb["homepage"].".online_status  ORDER BY time DESC LIMIT 1",$db->game);
		$cached = mysql_fetch_object($cachedq);
		if (!isset($cached->time) || time() > $cached->time+$plugin_conf->get("cachetimeout")) {
			$status = array();
				foreach($plugin_conf->get("check") as $ar) {
					try{
						$c = @fsockopen($ar["host"],$ar["port"],$errno,$errstr,$plugin_conf->get("timeout"));
					}
					catch (ErrorException $e){}
					if (isset($c) && is_resource($c)) {
						fclose($c);
						$status[] = array("name" => $ar["name"],"status" => 1);
					}else
						$status[] = array("name" => $ar["name"],"status" => 0);
					
				}
			
			$status = json_encode($status);
			if (isset($db->hp)) 
				mysql_query("INSERT INTO ".$db->hpdb["homepage"].".online_status (time,enc) VALUES('".time()."','".$status."')",$db->hp);
			else
				mysql_query("INSERT INTO ".$db->gamedb["homepage"].".online_status (time,enc) VALUES('".time()."','".$status."')",$db->game);
		}
		$out = "";
		if (isset($cached->enc)) {
			$status = json_decode($cached->enc,true);
			
			foreach($status as $stat) 
				if ($stat["status"])
					$out .= '<p class="on">'.$stat["name"]." ".$lang->get("online").'</p><div class="sb-sep"></div>';
				else
					$out .= '<p class="off">'.$stat["name"]." ".$lang->get("offline").'</p><div class="sb-sep"></div>';
		}
		$content = array("head" => array("title" => $lang->get("online_status_title")),"middle" => array("text" => substr($out,0,-26)));
		if ($plugin_conf->get("left"))
			$this->add("lside",$content);
		else
			$this->add("rside",$content);
	}
}