<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "text"
 * It just displays.. text
 */
include($config["path"]["includes"].$config["path"]["plugins"]."text/config.inc.php");
$content = $plugin_conf[$this->page];
unset($plugin_conf);
?>