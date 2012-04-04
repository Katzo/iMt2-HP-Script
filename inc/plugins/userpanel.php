<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called userpanel
 * It shows a login thingy or a user logged in stuff in the sidebar 
 */
include($config["path"]["includes"].$config["path"]["plugins"]."userpanel/config.inc.php");
if ($plugin_conf["left"])
	$build->addLSidebar($config["path"]["includes"].$config["path"]["plugins"]."userpanel/userpanel.sb.php");
else
	$build->addRSidebar($config["path"]["includes"].$config["path"]["plugins"]."userpanel/userpanel.sb.php");
$build->addJSFile("js/jquery.js");
$build->addJSFile("js/common.js");
unset($plugin_conf);
?>