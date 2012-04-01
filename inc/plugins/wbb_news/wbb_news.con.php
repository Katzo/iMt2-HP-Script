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
if (!isset($db->$plugin_config["wbbcon"])) $this->error("I could not find the database connection ".$plugin_config["wbbcon"]);
$wbbdb = $plugin_config["wbbcon"]."db";
if (!isset($db->$wbbdb[$plugin_config["wbbcon"]])) $this->error("I could not find the database index ".$plugin_config["wbbdb"]);
$q =mysql_query("SELECT id FROM ".$db->$wbbdb[$plugin_config["wbbcon"]].".thread");
$content = array("multi" => true);


?>