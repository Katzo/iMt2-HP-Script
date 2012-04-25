<?php
try{
	try{
		include("config.inc.php");
		if (!session_id()){
			session_name($config["settings"]["session_name"]);
			session_start();
		}
		include("lang.inc.php");
		include($config["path"]["includes"]."common.inc.php");
		if (!isset($pages[$p])) throw new Exception("I could not find the page '".$p."' you where looking for.<br/>I am sorry :(");
		$build = new build;
		include($config["path"]["includes"]."pluginloader.inc.php");
		foreach ($navilinks["header"] as $n)
			$build->addNavi($n);
		foreach ($navilinks["footer"] as $n)
			$build->addFooter($n);
		$build->build();
	}
	catch(Exception $e){
		new error($e->__toString());
	}
}
catch(ErrorException $e){
	new error($e->__toString());
}
?>
