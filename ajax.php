<?php
if (!session_id())
	session_start();
include("config.inc.php");
include("lang.inc.php");
$isajax = true;
include($config["path"]["includes"]."common.inc.php");
if (!isset($ajax[$p])) e404();
$db = new database;

include($config["path"]["includes"]."pluginloader.inc.php");
?>
