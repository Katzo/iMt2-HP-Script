<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called statistics
 * It shows total (online) players, accounts, guilds, items and stuff
 */
 include($config["path"]["includes"].$config["path"]["plugins"]."statistics/config.inc.php");
if ($plugin_conf["left"])
	$build->addLSidebar($config["path"]["includes"].$config["path"]["plugins"]."statistics/statistics.sb.php");
else
	$build->addRSidebar($config["path"]["includes"].$config["path"]["plugins"]."statistics/statistics.sb.php");
unset($plugin_conf);
?>
