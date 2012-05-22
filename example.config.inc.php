<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
$config = array(
	"db" => array(
		"game" => array(
			"host" => "localhost", // IP/Host of the MySQL Server
			"user" => "root", // Username
			"pass" => "", // Password
			"db" => array(
				"homepage" => "homepage",
				"account" => "account",
				"common" => "common",
				"player" => "player",
				"log" => "log",
				"board" => "board",
			)
		)
	),
	"path" => array(
		"includes" => "inc/", // General Path for includes
		"classes" => "classes/", // Path for classes (include path.classes path)
		"plugins" => "plugins/", // Path for plugins (include path.plugins path)
	),
);
?>