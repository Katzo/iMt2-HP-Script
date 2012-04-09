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
		"name" => "ExampleMt2",
		"baseurl" => "http://examplemt2.com",
		"coin" => "cash", // Coin column in account table
		"email_header" => 'From: Noreply <noreply@examplemt2.com>' . "\r\n", // Mail headers for sending mails
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
			"url" => "?p=home",
			"text" => "Home",
			"page" => "home",
		),
		array( // Yay for variable header MESS! :(
			"url" => ((isset($_SESSION["user"]) && !empty($_SESSION["user"]))?"?p=settings":"?p=register"),
			"text" => ((isset($_SESSION["user"]) && !empty($_SESSION["user"]))?"Settings":"Register"),
			"page" => ((isset($_SESSION["user"]) && !empty($_SESSION["user"]))?"settings":"register"),
		),
		array(
			"url" => "?p=download",
			"text" => "Download",
			"page" => "download",
		),
		array(
			"url" => "?p=ranking",
			"text" => "Ranking",
			"page" => "ranking",
		),
		array(
			"url" => "http://board.examplemt2.org",
			"text" => "Forum",
			"page" => "",
		),
		array(
			"url" => "http://board.examplemt2.org",
			"text" => "Forum",
			"page" => "",
		),
		array(
			"url" => "?p=itemshop",
			"text" => "Itemshop",
			"page" => "itemshop",
		),
		array(
			"url" => "ts3server://energymt2.org",
			"text" => "Teamspeak",
			"page" => "",
		),
		
	),
	"footer" => array(
	)
);
// Pages
$pages = array(
//   v this is $_GET["p"]
	"home" => array(
		"title" => false, // Overwrite title
		"plugins" => array("statistics","online_status","userpanel","sbranking","wbb_news") // List all plugins you want to load
	),
	"register" => array(
		"title" => false, // Overwrite title
		"plugins" => array("statistics","online_status","userpanel","sbranking","register") // List all plugins you want to load
	),
	"ranking" => array(
		"title" => false, // Overwrite title
		"plugins" => array("statistics","online_status","userpanel","sbranking","ranking") // List all plugins you want to load
	),
);
// Ajax
$ajax = array(
	"dologin" => "userpanel/dologin.ajax.php",
	"logout" => "userpanel/logout.php",
	"regcheck" => "register/regcheck.ajax.php",
	"ranking" => "ranking/ranking.ajax.php",
);
// URL Map
$urlmap = array(
	"forgot_password" => "?p=forgot", // URLs for Stuff - you dont have to search in every config to change them ..
	"donate" => "?p=donate", 
	"support" => "http://support.examplemt2.org", 
	"settings" => "?p=settings", 
	"itemshop" => "?p=itemshop",
	"char" => "?p=char",
	"register" => "?p=register",
	"logout" => "ajax.php?p=logout",
	"ranking" => "?p=ranking",
);
?>