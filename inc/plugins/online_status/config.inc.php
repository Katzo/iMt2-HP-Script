<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called online status
 * It shows the online status (duh) of defined ports
 */
 
$plugin_conf = array(
	"check" => array(
		array(
			"name" => "Channel 1",
			"host" => "localhost",
			"port" => 13000
		),
		array(
			"name" => "Channel 2",
			"host" => "localhost",
			"port" => 14000
		),
		array(
			"name" => "Channel 3",
			"host" => "localhost",
			"port" => 15000
		),
		array(
			"name" => "Channel 4",
			"host" => "localhost",
			"port" => 16000
		),
		array(
			"name" => "Channel 99",
			"host" => "localhost",
			"port" => 19000
		),
		array(
			"name" => "Login",
			"host" => "localhost",
			"port" => 11002
		),
	),
	"online" => "online",
	"offline" => "offline",
	"title" => "Online Status",
	"timeout" => 1, // Timeout for portchecks in seconds
	"left" => true, // Sidebar, 1 -> left, 0 -> right 
	"cachetimeout" => "120", // in seconds
);
?>
