<?php
class plugin_statistics extends Plugin{
	private $meta=array(
		"information"=>array(
			"name"=>"Statistics",
			"version"=>"1.0"
		),
		"requirements"=>array(
			"mysql"=>array(
				"hp"=>array(
					"homepage"=>array("statistics")
				),
				"game"=>array(
					"account"=>array("account"),
					"player"=>array("player","item","guild")
				)
			)
		)
	);
	private function generate(){
		global $db,$ConfigProvider,$lang;
		$plugin_conf=$ConfigProvider->get("plugin_statistics");
		if (isset($db->hp)) 
			$cachedq = mysql_query("SELECT * FROM ".$db->hpdb["homepage"].".statistics ORDER BY time DESC LIMIT 1",$db->hp);
		else
			$cachedq = mysql_query("SELECT * FROM ".$db->gamedb["homepage"].".statistics ORDER BY time DESC LIMIT 1",$db->game);
		$cached = mysql_fetch_object($cachedq);
		if (!isset($cached->time) || time() > $cached->time+$plugin_conf->get("cachetimeout")) {
			// Acc total
			$acc = mysql_fetch_object(mysql_query("SELECT count(id) as c FROM ".$db->gamedb["account"].".account",$db->game));
			// Player total
			$player = mysql_fetch_object(mysql_query("SELECT count(id) as c FROM ".$db->gamedb["player"].".player",$db->game));
			// Guild total
			$guild = mysql_fetch_object(mysql_query("SELECT count(id) as c FROM ".$db->gamedb["player"].".guild",$db->game));
			// Item total
			$item = mysql_fetch_object(mysql_query("SELECT sum(count) as c FROM ".$db->gamedb["player"].".item",$db->game));
			// Player online
			$playero = mysql_fetch_object(mysql_query("SELECT count(id) as c FROM ".$db->gamedb["player"].".player WHERE last_play > DATE_SUB(NOW(), INTERVAL 10 MINUTE)",$db->game));
			if (isset($db->hp))
				mysql_query("INSERT INTO ".$db->hpdb["homepage"].".statistics (time,acc,player,guild,item,playero) VALUES('".time()."','".$acc->c."','".$player->c."','".$guild->c."','".$item->c."','".$playero->c."')",$db->hp);
			else
				mysql_query("INSERT INTO ".$db->gamedb["homepage"].".statistics (time,acc,player,guild,item,playero) VALUES('".time()."','".$acc->c."','".$player->c."','".$guild->c."','".$item->c."','".$playero->c."')",$db->game);
		}
		$content = array(
			"head" => array("title" => $lang->get("statistics")),
			"middle" => array("text" => '<p class="info"><strong>'.$cached->acc.'</strong> '.$lang->get("statistics_accounts").'</p>' .
						'<div class="sb-sep"></div><p class="info"><strong>'.$cached->playero.'</strong> '.$lang->get("statistics_playero").'</p>' .
						'<div class="sb-sep"></div><p class="info"><strong>'.$cached->player.'</strong> '.$lang->get("statistics_player").'</p>'.
						'<div class="sb-sep"></div><p class="info"><strong>'.$cached->guild.'</strong> '.$lang->get("statistics_guild").'</p>'.
						'<div class="sb-sep"></div><p class="info"><strong>'.$cached->item.'</strong> '.$lang->get("statistics_item").'</p>')
		);
		if ($plugin_conf->get("left"))
			$this->add("lside",$content);
		else
			$this->add("rside",$content);
	}
}
?>