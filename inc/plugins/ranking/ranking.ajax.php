<?php

if (isset($_POST["page"]) && isset($_POST["name"]) && isset($_POST["job"])) {
	$plugin_conf=$ConfigProvider->get("plugin_ranking");
	$rpage = (int)$_POST["page"];
	$limit = 'LIMIT '.($plugin_conf->get("cpp")*($rpage-1)).",".$plugin_conf->get("cpp");
	$where = false;
	$name = false;
	$job = false;
	if (!empty($_POST["name"]) || $_POST["job"] != -1)
		$where = true;
	if (!empty($_POST["name"])) 
		$name = true;
	if ($_POST["job"] != -1)
		$job = true;
	$select = "SELECT i,ji,name,level,job";
	$selcount = "SELECT count(i) as c"; // Optimized for InnoDB tables - when using MyISAM count(*) is way faster
	if (isset($db->hp))
		$bsql = ' FROM '.$db->hpdb["homepage"].'.ranking_cache '.($where?'WHERE ':'').($name?'name LIKE "%'.mysql_real_escape_string($_POST["name"]).'%" ':'').($job&&$name?'AND ':'').($job?'job ="'.(int)$_POST["job"].'"':'');
	else
		$bsql = ' FROM '.$db->gamedb["homepage"].'.ranking_cache '.($where?'WHERE ':'').($name?'name LIKE "%'.mysql_real_escape_string($_POST["name"]).'%" ':'').($job&&$name?'AND ':'').($job?'job ="'.(int)$_POST["job"].'"':'');
	$q = mysql_query($select.$bsql.$limit,(isset($db->hp)?$db->hp:$db->game));
	echo '<table><tr><th>#</th><th>'.$lang->get("ranking_classrank").'</th><th>'.$lang->get("charname").'</th><th>'.$lang->get("class").'</th><th>'.$lang->get("level").'</th></tr>';
	while ($res = mysql_fetch_object($q)){
		if ($res->job == 0 )
			$j = $lang->get("warrior");
		elseif ($res->job == 1) 
			$j = $lang->get("assassin");
		elseif ($res->job == 2) 
			$j = $lang->get("sura");
		elseif ($res->job == 3) 
			$j = $lang->get("shaman");
		echo '<tr><td>'.$res->i.'</td><td>'.$res->ji.'</td><td>'.$res->name.'</td><td>'.$j.'</td><td>'.$res->level.'</td></tr>';
	}
	echo "</table>";
	$count = mysql_fetch_object(mysql_query($selcount.$bsql,(isset($db->hp)?$db->hp:$db->game)))->c;
	$totalPages = ceil($count/$plugin_conf->get("cpp"));
	if ($totalPages < 13) {
		for($i=1;$i <=$totalPages;$i++) {
			if ($i == $rpage) 
				echo $i." ";
			else
				echo "<a class='rpage' href='#' onclick='javascript:g_rpage=".$i.";ranking();return false;'>".$i."</a> ";
		}
	}else{
		$pagea = array();
		$pagea[] = 1;
		$pagea[] = 2;
		$pagea[] = 3;
		if ($rpage < 3 || $rpage > $totalPages-2) {
			$pagea[] = 0;
			$pagea[] = ceil($totalPages/2)-2;
			$pagea[] = ceil($totalPages/2)-1;
			$pagea[] = ceil($totalPages/2);
			$pagea[] = ceil($totalPages/2)+1;
			$pagea[] = ceil($totalPages/2)+2;
			$pagea[] = 0;
		}else{
			if ($rpage > 6) $pagea[] = 0;
			if ($rpage-2 > 4) { 
				$pagea[] = $rpage-2;
				if ($rpage-1 > 4) $pagea[] = $rpage-1;
			}
			if ($rpage > 3 && $rpage < $totalPages-2)$pagea[] = $rpage;
			if ($rpage+1 < $totalPages-2){ 
				$pagea[] = $rpage+1;
				if ($rpage+2 < $totalPages-2) 
					$pagea[] = $rpage+2;
			}
			if ($rpage < $totalPages-5) $pagea[] = 0;
		}
		$pagea[] = $totalPages-2;
		$pagea[] = $totalPages-1;
		$pagea[] = $totalPages;
		
		foreach($pagea as $pp)	
			if ($pp) 
				if ($pp == $rpage)
					echo $pp." ";
				else
					echo "<a onclick='javascript:g_rpage=".$pp.";ranking();return false;'>".$pp."</a> ";
			else
				echo "&nbsp;...&nbsp;";
	}
	echo '<br/><span style="display:block;text-align:center;"><input type="button" onclick="javascript:if (g_rpage==1) return false;g_rpage-=1;ranking();" value="'.$lang->get("back").'" class="btn" /><input type="button" onclick="javascript:if (g_rpage>='.$totalPages.') return false;g_rpage+=1;ranking();" value="'.$lang->get("next").'" class="btn" /></span>';
}else
	die("Nope! I won't say anything! :<");

?>