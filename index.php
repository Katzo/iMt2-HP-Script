<?php
error_reporting(0); // Dont spam any errors in browser
if (!session_id())
	session_start();
include("config.inc.php");
include("lang.inc.php");
include($config["path"]["includes"]."common.inc.php");
if (!isset($pages[$p])) e404();
$build = new build;
include($config["path"]["includes"]."pluginloader.inc.php");
foreach ($navilinks["header"] as $n)
	$build->addNavi($n);
foreach ($navilinks["footer"] as $n)
	$build->addFooter($n);
$build->build();
?>
