<?php
include("config.inc.php");
session_name($config["settings"]["session_name"]);
session_start();
include("lang.inc.php");
$isajax = true;
include($config["path"]["includes"]."common.inc.php");
if (!isset($ajax[$p])) e404();
$db = new database;

include($config["path"]["includes"]."pluginloader.inc.php");
?>
