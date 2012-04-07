<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "wbb news"
 * It shows the newest threads from a specific forum  (WBB 3)
 * (This is usefull for news :D)
 */
$plugin_conf = array(
	"wbbcon" => "game", // Name of the wbb connection
	"wbbdb" => "board", // Name of wbb database index
	"id" => 1,
	/* Provide a single id or an array with the board ids from where threads are taken (Sub Forums included!)
	 * "id" => 1,
	 * or 
	 * "id" => array(1,2,3,4,5,6,7),
	 */
	"count" => 5, // how many
	"boardid" => 1,
	"installationid" => 1,
	"boardurl" => "http://board.examplemt2.com/", // 
	"by" => "by",
	"more" => "Read more"
);
?>