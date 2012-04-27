<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "wbb news"
 * It shows the newest threads from a specific forum  (WBB 3)
 * (This is usefull for news :D)
 */
include($config["path"]["includes"].$config["path"]["plugins"]."wbb_news/config.inc.php");
if (!isset($db->$plugin_conf["wbbcon"])) throw new Exception("I could not find the database connection ".$plugin_conf["wbbcon"]);
$wbbdb = $plugin_conf["wbbcon"]."db";
if (!array_key_exists("board",$db->$wbbdb)) throw new Exception("I could not find the database index board");
if (is_array($plugin_conf["id"])){
	$qstr ="";
	foreach($plugin_conf["id"] as $i)
		$qstr .= "(wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.parentID = '".$i."' or wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.boardID = '".$i."') OR";
	$qstr = substr($qstr,0,-2);
	$q = mysql_query("SELECT threadID,topic,firstPostPreview,userID,username,wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.time FROM ".$db->{$wbbdb}["board"].".wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread JOIN ".$db->{$wbbdb}["board"].".wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board ON wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.boardID = wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.boardID OR wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.boardID = wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.parentID WHERE (".$qstr.") and isDeleted=0 ORDER BY time DESC LIMIT ".$plugin_conf["count"]);
}else
	$q = mysql_query("SELECT threadID,topic,firstPostPreview,userID,username,wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.time FROM ".$db->{$wbbdb}["board"].".wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread JOIN ".$db->{$wbbdb}["board"].".wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board ON wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.boardID = wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.boardID OR wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.boardID = wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.parentID WHERE wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.parentID = '".$plugin_conf["id"]."' or wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.boardID = '".$plugin_conf["id"]."' and isDeleted=0 ORDER BY time DESC LIMIT ".$plugin_conf["count"]);
echo mysql_error();
$content = array("multi" => true);
while ($res = mysql_fetch_object($q))
	$content[] = array(
		"head" => array(
			"title" => htmlentities($res->topic),
			"date" => $plugin_conf["by"].' <a href="'.$plugin_conf["boardurl"].'?page=User&userID='.$res->userID.'">'.$res->username.'</a>, '.timetostr($res->time).'',
		),
		"middle" => array(
			"text" => str_replace("\n","<br/>",str_replace("€","&euro;",htmlentities($res->firstPostPreview,ENT_COMPAT,"ISO-8859-15")))
		), 
		"footer" => array(
			"more" => $plugin_conf["boardurl"].'?page=Thread&threadID='.$res->threadID,
			"what" => $plugin_conf["more"]
		)
	);

// ?page=Thread&threadID=7
?>