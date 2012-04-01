<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
 spl_autoload_register("__autoload");
 function __autoload($name) {
 	global $config;
 	include($config["path"]["includes"].$config["path"]["classes"].$name.".class.php");
 }
 $p = ((isset($_GET["p"]))?$_GET["p"]:"home");
 function e404() {
 	header("Status: 404 Not Found");
 	die("<h1>I made a mistake! Help! :(</h1>I could not find the page you were looking for... :(");
 }
?>
