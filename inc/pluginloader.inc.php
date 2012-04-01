<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This file autoloads all .php files in the plugin folder which you configured via $page[$_GET["p"]]["plugins"]
 */
 foreach ($page[$p]["plugin"] as $file) { 
    $filename = $file.".php";
    include($filename);
 }
 
?>
