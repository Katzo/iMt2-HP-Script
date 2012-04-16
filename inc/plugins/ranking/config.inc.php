<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "ranking"
 * guess what it does.
 */
$plugin_conf = array(
	"cpp" => 40, // Characters per page
	"buildcache" => true, // Build the cache when someone views the site
	"cachetimeout" =>144000, // in seconds  (Default: 4hours)
	/*
	 * I do NOT recommend using this.
	 * my rebuild script sucks and i don't have the patience to think about improving it.
	 * You should set up a cronjob that executes:
	 * cd /path/to/website/inc/plugins/statistics/ && php buildcache.cl.php
	 */
);
?>