<?php

if (!session_id())
	session_start();
try{
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
}
catch(Exception $e){
	new Error($e->__toString());
}
catch(ErrorException $e){
	new Error($e->__toString());
}
?>
