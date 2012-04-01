<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called sbranking
 * It shows a small ranking in the sidebar
 * It requires the default Ranking script (cached ranking database)
 */
 
$plugin_conf = array(
	"title" => "Ranking", // Title
	"left" => true, // Sidebar, 1 -> left, 0 -> right 
	"count" => 10, // how many players to list
	"buildcache" => true, // Build the cache when someone views the site
	"cachetimeout" =>144000, // in seconds  (Default: 4hours)
	/*
	 * I do NOT recommend using this for larger databases.
	 * You should set up a cronjob that executes:
	 * php /path/to/website/includes/plugins/statistics/buildcache.cl.php
	 */
);
?>
