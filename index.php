<?php
include("config.inc.php");
include($config["path"]["includes"]."common.inc.php");
$build = new build;
include($config["path"]["includes"]."pluginloader.inc.php");
$build->build();
?>
