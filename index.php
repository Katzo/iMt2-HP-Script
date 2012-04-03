<?php
if (!session_id())
	session_start();
include("config.inc.php");
include($config["path"]["includes"]."common.inc.php");
if (!isset($pages[$p])) e404();
$build = new build;
foreach ($navilinks["header"] as $n)
	$build->addNavi($n);
foreach ($navilinks["footer"] as $n)
	$build->addFooter($n);

include($config["path"]["includes"]."pluginloader.inc.php");
$build->build();
?>
