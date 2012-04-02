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
if (!isset($db->$plugin_conf["wbbcon"])) $this->error("I could not find the database connection ".$plugin_conf["wbbcon"]);
$wbbdb = $plugin_conf["wbbcon"]."db";
echo $wbbdb;
if (!isset($db->$wbbdb["board"])) $this->error("I could not find the database index ".$plugin_conf["wbbdb"]);
$q = mysql_query("SELECT threadID,topic,firstPostPreview,userID,username,wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.time FROM ".$db->$wbbdb["board"].".wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread JOIN ".$db->$wbbdb["board"].".wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board ON wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.boardID = wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.boardID OR wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_thread.boardID = wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.parentID WHERE wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.parentID = '".$plugin_conf["id"]."' or wbb".$plugin_conf["boardid"]."_".$plugin_conf["installationid"]."_board.boardID = '".$plugin_conf["id"]."' and isDeleted=0 ORDER BY time DESC LIMIT ".$plugin_conf["count"]);
$content = array("multi" => true);
while ($res = mysql_fetch_object($q)) {
	$content[] = array(
		"title" => array(
			"title" => htmlentities($res->topic),
			"date" => $plugin_conf["by"].' <a href="'.$plugin_conf["boardurl"].'?page=User&userID='.$res->userID.'">'.$res->username.', '.timetostr($res->time).'</a>',
		),
		"middle" => array(
			"text" => htmlentities($res->firstPostPreview)
		), 
		"footer" => array(
			"more" => $plugin_conf["boardurl"].'?page=Thread&ThreadID='.$res->ThreadID
		)
	);
}
// ?page=Thread&threadID=7
?>