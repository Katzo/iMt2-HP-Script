<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
 spl_autoload_register("__autoload");
 function __autoload($name) {
 	include($config["path"]["includes"].$config["path"]["classes"].$name);
 }
?>
