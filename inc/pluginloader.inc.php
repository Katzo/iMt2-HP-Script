<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This file autoloads all .php files in the plugin folder which you configured via $page[$_GET["p"]]["plugins"]
 */
 if (isset($isajax)){
 	$filename =$config["path"]["includes"].$config["path"]["plugins"].$ajax[$p];
	include($filename);
}else
	 foreach ($pages[$p]["plugins"] as $file) { 
	    $filename =$config["path"]["includes"].$config["path"]["plugins"].$file."/".$file.".class.php";
	    include($filename);
	}

?>
