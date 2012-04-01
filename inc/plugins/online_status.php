<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called online status
 * It shows the online status (duh) of defined ports
 */
include($config["path"]["includes"].$config["path"]["plugins"]."online_status/config.inc.php");
if ($plugin_conf["left"])
	$build->addLSidebar($config["path"]["includes"].$config["path"]["plugins"]."online_status/online_status.sb.php");
else
	$build->addRSidebar($config["path"]["includes"].$config["path"]["plugins"]."online_status/online_status.sb.php");
unset($plugin_conf);
?>
