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
include($config["path"]["includes"].$config["path"]["plugins"]."sbranking/config.inc.php");
if ($plugin_conf["left"])
	$build->addLSidebar($config["path"]["includes"].$config["path"]["plugins"]."sbranking/sbranking.sb.php");
else
	$build->addRSidebar($config["path"]["includes"].$config["path"]["plugins"]."sbranking/sbranking.sb.php");
unset($plugin_conf);
?>
