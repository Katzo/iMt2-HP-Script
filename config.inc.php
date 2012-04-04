<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
// Config array
$config = array(
	"db" => array(
		"game" => array( //Yes you can add multiple database connection, it's not pretty though..
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
		/* 
		 * Just on a sidenote:
		 * all the default plugins which use the "homepage" database support external connections
		 * Just call the connection "hp" and it will prefer this over the game one
		 **/
		)
	),
	"settings" => array(
		"title" => "ExampleMt2",
		"baseurl" => "http://examplemt2.com",
		"coin" => "cash", // Coin column in account table
		
	),
	"path" => array(
		"includes" => "inc/", // General Path for includes
		"classes" => "classes/", // Path for classes (include path.classes path)
		"plugins" => "plugins/", // Path for plugins (include path.plugins path)
	),
);
// Navi
$navilinks = array(
	"header" =>array(
		array(
			"url" => "index.php?p=home",
			"text" => "Home",
			"page" => "home",
		),
	),
	"footer" => array(
	)
);
// Lang
$lang = array(
	"time" => array(
		"s" => "seconds",
		"S" => "second",
		"m" => "minutes",
		"M" => "minute",
		"h" => "hours",
		"H" => "hour",
		"a" => "ago",
		"af" => "a few",
		"format" => "%value %time %ago",
		"tformat" => "d.m.y H:i"
	),
	"misc" => array(
		"fillout" => "Please fill out all fields",
		"coin" => "Coin",
		"coins" => "Coins",
		"noacc" => "No account with that password or username found",
		"pass" => "Password",
		"user" => "Username",
		"login" => "Login",
		"register" => "Register"
	),
);
// Pages
$pages = array(
//   v this is $_GET["p"]
	"home" => array(
		"title" => false, // Overwrite title
		"plugins" => array("statistics") // List all plugins you want to load
	),
);
// Ajax
$ajax = array(
	"dologin" => "userpanel/dologin.ajax.php"
);
?>