<?php

if (isset($_POST["page"]) && isset($_POST["name"]) && isset($_POST["job"])) {
	include($config["path"]["includes"].$config["path"]["plugins"]."ranking/config.inc.php");
	$rpage = (int)$_POST["page"];
	$limit = 'LIMIT '.($plugin_conf["cpp"]*($rpage-1)).",".$plugin_conf["cpp"];
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
	echo '<table><tr><th>#</th><th>'.$lang["misc"]["classrank"].'</th><th>'.$lang["misc"]["charname"].'</th><th>'.$lang["misc"]["class"].'</th><th>'.$lang["misc"]["level"].'</th></tr>';
	while ($res = mysql_fetch_object($q)){
		if ($res->job == 0 )
			$j = $lang["misc"]["warrior"];
		elseif ($res->job == 1) 
			$j = $lang["misc"]["assassin"];
		elseif ($res->job == 2) 
			$j = $lang["misc"]["sura"];
		elseif ($res->job == 3) 
			$j = $lang["misc"]["shaman"];
		echo '<tr><td>'.$res->i.'</td><td>'.$res->ji.'</td><td>'.$res->name.'</td><td>'.$j.'</td><td>'.$res->level.'</td></tr>';
	}
	echo "</table>";
	$count = mysql_fetch_object(mysql_query($selcount.$bsql,(isset($db->hp)?$db->hp:$db->game)))->c;
	$totalPages = $count/$plugin_conf["cpp"];
	if ($totalPages < 13) {
		for($i=1;$i <=$totalPages;$i++) {
			if ($i == $rpage) 
				echo $i." ";
			else
				echo "<a href='#' onclick='javascript:g_rpage=".$i.";ranking();return false;'>".$i."</a>";
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
					echo "<a onclick='javascript:g_rpage=".$i.";ranking();return false;'>".$pp."</a>";
			else
				echo "&nbsp;...&nbsp;";
	}
}else
	die("Nope! I won't say anything! :<");

?>