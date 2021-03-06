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
		"timezone" => "Europe/Berlin", // http://www.php.net/manual/en/timezones.php
		"baseurl" => "http://examplemt2.com/", // Including last /
		"coin" => "cash", // Coin column in account table
		"email_header" => 'From: Noreply <noreply@examplemt2.com>' . "\r\n", // Mail headers for sending mails
		"session_name" => "imt2_hp", // In case you are using multiple script on one domain you have to change this
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
			"url" => "home",
			"text" => "Home",
			"page" => "home",
		),
		array(
			"url" =>  "register",
			"text" => "Register",
			"page" => "register",
			"loggedin" => false,
		),
		array(
			"url" => "settings",
			"text" => "Settings",
			"page" => "settings",
			"loggedin" => true,
		),
		array(
			"url" => "download",
			"text" => "Download",
			"page" => "download",
		),
		array(
			"url" => "ranking",
			"text" => "Ranking",
			"page" => "ranking",
		),
		array(
			"url" => "http://board.examplemt2.org",
			"text" => "Forum",
			"page" => "",
		),
		array(
			"url" => "itemshop",
			"text" => "Itemshop",
			"page" => "itemshop",
		),
		array(
			"url" => "ts3server://examplemt2.org",
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
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","register")
	),
	"ranking" => array(
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","ranking")
	),
	"download" => array(
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","text")
	),
	"settings" => array(
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","settings")
	),
	"itemshop" => array(
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","itemshop")
	),
	"donate" => array(
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","donate_psc")
	),	
	"vote" => array(
		"title" => false,
		"plugins" => array("statistics","online_status","userpanel","sbranking","vote4coins")
	)
	
);
// Ajax
$ajax = array(
	"dologin" => "userpanel/dologin.ajax.php",
	"logout" => "userpanel/logout.php",
	"regcheck" => "register/regcheck.ajax.php",
	"ranking" => "ranking/ranking.ajax.php",
	"settings" => "settings/settings.ajax.php",
	"itemshop_buy" => "itemshop/buy.ajax.php",
	"vote4coins" => "vote4coins/vote4coins.ajax.php",
);
/* URL Map
 * Please use relative links if possible
 * I'm only needing relative links for the donate link in the ingame itemshop at the moment - but that could change in the future
 * ../DONATELINK is what i'm doing. :)
 */
/*
 * mod_rewrite enabled:
 */
$urlmap = array(
	"forgot_password" => "forgot", // URLs for Stuff - you dont have to search in every config to change them ..
	"donate" => "donate", 
	"support" => "http://support.examplemt2.org", 
	"settings" => "settings", 
	"itemshop" => "itemshop",
	"char" => "char",
	"register" => "register",
	"logout" => "ajax.php?p=logout",
	"ranking" => "ranking",
);
?>