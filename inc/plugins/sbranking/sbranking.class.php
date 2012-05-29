<?php
class plugin_sbranking extends Plugin{
	private $meta=array(
		"information"=>array(
			"name"=>"Sidebar Ranking",
			"version"=>"1.0"
		),
		"requirements"=>array(
			"plugins"=>array("ranking"),
			"mysql"=>array(
				"hp"=>array(
					"homepage"=>array("ranking_cache")
				)
			)
		)
	);
	private function generate(){
		global $db,$ConfigProvider,$lang,$config;
		$plugin_conf=$ConfigProvider->get("plugin_sbranking");
		$urlmap=$ConfigProvider->get("urlmap");
		if ($plugin_conf->get("buildcache")) {
			/*
			 * Check if we need to rebuild the cache
			 */
			 if (isset($db->hp)) 
			 	$q = mysql_query("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db->hpdb["homepage"]."' and TABLE_NAME='ranking_cache' LIMIT 1",$db->hp);
			 else
			 	$q = mysql_query("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db->gamedb["homepage"]."' and TABLE_NAME='ranking_cache' LIMIT 1",$db->game);
			$res = mysql_fetch_object($q);
			if (time() > $res->TABLE_COMMENT+$plugin_conf->get("cachetimeout")) {
				$this->add("bgjob",$config["path"]["includes"].$config["path"]["plugins"]."ranking/buildcache.inc.php");
			}
		}
		if (isset($db->hp)) 
			$q = mysql_query("SELECT i,name,level FROM ".$db->hpdb["homepage"].".ranking_cache ORDER BY i ASC LIMIT ".$plugin_conf->get("count"),$db->hp);
		else
			$q = mysql_query("SELECT i,name,level FROM ".$db->gamedb["homepage"].".ranking_cache ORDER BY i ASC LIMIT ".$plugin_conf->get("count"),$db->game);
		$b = "";
		while ($res = mysql_fetch_object($q))
			$b .="<tr><td>".$res->i."</td><td>".$res->name."</td><td>".$res->level."</td></tr>";
		$content = array(
			"head" => array(
				"title" => $lang->get("ranking")
			),
			"middle" => array(
				"text" => '<table class="sbranking"><tr><td>#</td><td>'.$lang->get("charname").'</td><td>'.$lang->get("level").'</td>'.$b.'</table><a class="sb-link" href="'.$urlmap["ranking"].'">'.$lang->get("ranking").'</a>'
			)
		);
		if ($plugin_conf->get("left"))
			$this->add("lside",$content);
		else
			$this->add("rside",$content);
	}
}
?>