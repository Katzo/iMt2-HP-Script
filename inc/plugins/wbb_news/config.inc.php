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
	"id" => 1, // Boards (including sub-boards) from which threads are taken
	"count" => 5, // how many
	"boardid" => 1,
	"installationid" => 1,
	"boardurl" => "http://board.examplemt2.com/", // 
	"by" => "by"
);
?>