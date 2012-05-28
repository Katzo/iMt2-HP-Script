<?php
class plugin_ranking extends Plugin{
	private $meta = array(
		"information"=>array(
			"name"=>"Ranking",
			"version"=>"1.0"
		),
		"requirements"=>array(
			"mysql"=>array(
				"hp"=>array(
					"homepage"=>array("ranking_cache")
				)
			)
		)
	);
	private function generate(){
		global $db,$ConfigProvider,$config,$lang;
		$plugin_conf=$ConfigProvider->get("plugin_ranking");
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
		$this->add("content",array(
			"head" => array(
				"title" => $lang->get("ranking")
			),
			"middle" => array(
				"text" => '<form onsubmit="javascript:g_rname=$(\'#rname\').val();g_rpage=1;ranking();return false;"><div class="rankingsearch"><input type="text" id="rname" class="bar" onblur="javascript:g_rname=$(this).val();g_rpage=1;ranking();" placeholder="'.$lang->get("ranking_search_placeholder").'"/><input class="btn" type="submit" value="'.$lang->get("ranking_search").'"/></div></form>
						<div class="rankingbuttons"><input class="btn" type="button" value="'.$lang->get("ranking_allclasses").'" onclick="javascript:g_rjob=-1;ranking();"/>
						<input class="btn" type="button" value="'.$lang->get("warrior").'" onclick="javascript:g_rjob=0;g_rpage=1;ranking();"/>
						<input class="btn" type="button" value="'.$lang->get("assassin").'" onclick="javascript:g_rjob=1;g_rpage=1;ranking();"/>
						<input class="btn" type="button" value="'.$lang->get("sura").'" onclick="javascript:g_rjob=2;g_rpage=1;ranking();"/>
						<input class="btn" type="button" value="'.$lang->get("shaman").'" onclick="javascript:g_rjob=3;g_rpage=1;ranking();"/></div>
						<br/><br/><br/>
						<img id="rloading" src="images/ui/loading_bar.gif" style="margin:auto;display:block;"/>
						<div id="rankingres" class="ranking"></div>'
			)
		));
		$build->add("jsfile","js/jquery.js");
		$build->add("js","var g_rpage=1;
		var g_rjob=-1;
		var g_rname='';
		function ranking(){
			$('#rloading').fadeIn(200);
			$.ajax({
				type: 'POST',
				url: 'ajax.php?p=ranking',
				data: {page:g_rpage,job:g_rjob,name:g_rname},
				success: function(data){
					$('#rankingres').html(data);
				},
			});
			$('#rloading').fadeOut(200);
		}
		ranking();");
	}
}