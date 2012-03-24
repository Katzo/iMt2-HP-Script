<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * (c) imer.cc 2012
 */
// Config array
$config = array(
	"db" => array(
		"host" => "localhost", // IP/Host of the MySQL Server
		"user" => "root", // Username
		"pass" => "", // Password
		"db" => array(
			"homepage" => "homepage",
			"account" => "account",
			"common" => "common",
			"player" => "player",
			"log" => "log"
		)
	),
	"settings" => array(
		"title" => "ExampleMt2",
		"baseurl" => "examplemt2.com",
		"redirect" => true, // Redirect to baseurl when not connecting on baseurl,
		"meta-desc" => "This is the example base design of the iMt2 Homepoage Script by iMer" // Meta Describtion tag for search engines
	),
	"path" => array(
		"includes" => ""
	),
	"design" => array(
		"header" => "design/header.php",
		"base" => "design/base.php",
		"footer" => "design/footer.php",
	)
);
?>