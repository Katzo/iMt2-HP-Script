<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "text"
 * It just displays.. text
 */
$plugin_conf= array(
	"download" => array(
		"multi" => true,
		array(
			"head" => array(
				"title" => $lang["misc"]["download"]
			),
			"middle" => array(
				"text" => '<div class="innertable">
					<table>
						<tr><td>Full download:</td><td><a href="http://patch.examplemt2.com/client.zip">Mirror #1</a></td></tr>
						<tr><td></td><td><a href="http://patch2.examplemt2.com/client.zip">Mirror #2</a></td></tr>
						<tr><td>Patcher only:</td><td><a href="http://patch.examplemt2.com/patcher.zip">Mirror #1</a></td></tr>
						<tr><td></td><td><a href="http://patch2.examplemt2.com/patcher.zip">Mirror #2</a></td></tr>
					</table>
				</div>
				'
			)
		),
		array(
			"head" => array(
				"title" => $lang["misc"]["systemrequirements"]
			),
			"middle" => array(
				"text" => "<div class='innertable'>
				<table>
					<tr><td>".$lang["sysreq"]["os"]."</td><td>Win XP, Win 2000, Win Vista, Win 7</td></tr>
					<tr><td>".$lang["sysreq"]["cpu"]."</td><td>Pentium 4 1.8GHz</td></tr>
					<tr><td>".$lang["sysreq"]["mem"]."</td><td>1 GB</td></tr>
					<tr><td>".$lang["sysreq"]["hdd"]."</td><td>2 GB</td></tr>
					<tr><td>".$lang["sysreq"]["graphics"]."</td><td>> 64MB RAM</td></tr>
					<tr><td>".$lang["sysreq"]["sound"]."</td><td>Support DirectX 9.0</td></tr>
				</table></div>"
			)
		)
	)
);
?>