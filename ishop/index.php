<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is the Ingame Itemshop - part of the Itemshop plugin
 * Not everyone is using Apache and has access to mod rewrite or something like that
 * Its probably the best solution in terms of compability
 * It also isnt coded that variable/nice but meh. whatever
 */
// Prevent anyone from illegally accessing this.
if (!session_id())
	session_start();
if (!isset($_SESSION["user"]) && (!isset($_GET["sas"]) || !isset($_GET["pid"]) || !isset($_GET["sid"])) || !is_numeric($_GET["pid"]) || !is_numeric($_GET["sid"])) exit;
include("../config.inc.php");
include("../lang.inc.php");
include($config["path"]["includes"]."common.inc.php");
$db = new database;
if (!isset($_SESSION["user"])){
	$id = mysql_fetch_object(mysql_query('SELECT account_id FROM '.$db->gamedb["player"].'.player WHERE id="'.(int)$_GET["pid"].'"'));
	if (!$id) exit;
	$id = $id->account_id;
	if ($_GET["sas"] = md5($_GET["pid"].$_GET["sid"]."GF9001")){
		$res = mysql_fetch_object(mysql_query('SELECT login,'.$config["settings"]["coin"].' as coin FROM '.$db->gamedb["account"].'.account WHERE id="'.$id.'"',$db->game));
		$_SESSION["user"] = $res->login;
		$_SESSION["coins"] = $res->coin;
		$_SESSION["id"] = $id;
	}else exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Itemshop</title>
		<link href="../css/ishop.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="wrapper">
			<div id="head">
				<div class="postui post-start">
				</div>
				<div class="postui post-con">
					<div class="con-wrap">
						 <?php str_replace("%coinname",$lang["misc"]["coins"],str_replace("%coins",$_SESSION["coins"],$lang["misc"]["youcoin"])).' <a href="'.$urlmap["donate"].'">'.$lang["misc"]["donate"].'?</a>'; ?>
					</div>
				</div> 
				<div class="postui post-end"></div>
			</div>
			<div id="navi">
				<div class="sb-title"><h3><?php echo $lang["itemshop"]["cat"]; ?></h3></div>
				<div class="sb-con">
					<?php
					if (isset($db->hp))
						$q = mysql_query('SELECT id,name FROM '.$db->hpdb["homepage"].'.itemshop_category WHERE enabled=1',$db->hp);
					else
						$q = mysql_query('SELECT id,name FROM '.$db->gamedb["homepage"].'.itemshop_category WHERE enabled=1',$db->game);
					while ($res = mysql_fetch_object($q)){
						if (isset($_GET["cat"]) && $_GET["cat"] == $res->id) $isavcat = true; 
						echo '<input type="button" onclick="location.href=\'?cat='.$res->id.'\'"class="btn" value="'.$res->name.'"/>';
					}
					?>
				</div>
				<div class="sb-end"></div>
			</div>
			<div id="conwrapper">
			<?php
				if (isset($_GET["cat"])) {
					if (isset($isavcat)){
						if (isset($db->hp))
							$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->hpdb["homepage"].'.itemshop_package WHERE enabled=1 and cat="'.mysql_real_escape_string($_GET["cat"]).'"',$db->hp);
						else
							$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->gamedb["homepage"].'.itemshop_package WHERE enabled=1 and cat="'.mysql_real_escape_string($_GET["cat"]).'"',$db->game);
							while ($res = mysql_fetch_object($q))
								echo '<div class="postui post-title"><h2>'.$res->name.'</h2></div>
									<div class="postui post-con">
										<div class="con-wrap">
											<p><img class="thumb" src="'.$res->img.'" alt="" />
											'.$res->desc.'
											</p>
											<div class="sep"></div>
											'.$lang["itemshop"]["price"].': <b>'.$res->price.'</b> '.($res->price==1?$lang["misc"]["coin"]:$lang["misc"]["coins"]).' <span class="right"><a onclick="javascript:buy($(this).parent(),'.$res->id.');return false;" class="more">'.$lang["itemshop"]["buy"].'</a></span>'.'
										</div>
									</div> 
									<div class="postui post-end"></div>';
					}else
						echo '<div class="postui post-title"><h2>'.$lang["misc"]["notfound"].'</h2></div>
							<div class="postui post-con">
								<div class="con-wrap">
									'.$lang["misc"]["notfound"].'
								</div>
							</div> 
							<div class="postui post-end"></div>';
				}else{
					if (isset($db->hp))
						$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->hpdb["homepage"].'.itemshop_package WHERE enabled=1 ORDER BY added DESC LIMIT '.$plugin_conf["newest_count"],$db->hp);
					else
						$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->gamedb["homepage"].'.itemshop_package WHERE enabled=1 ORDER BY added DESC LIMIT '.$plugin_conf["newest_count"],$db->game);
					while ($res = mysql_fetch_object($q))
						echo '<div class="postui post-title"><h2>'.$res->name.'</h2></div>
						<div class="postui post-con">
							<div class="con-wrap">
								<p><img class="thumb" src="'.$res->img.'" alt="" />
								'.$res->desc.'
								</p>
								<div class="sep"></div>
								'.$lang["itemshop"]["price"].': <b>'.$res->price.'</b> '.($res->price==1?$lang["misc"]["coin"]:$lang["misc"]["coins"]).' <span class="right"><a onclick="javascript:buy($(this).parent(),'.$res->id.');return false;" class="more">'.$lang["itemshop"]["buy"].'</a></span>'.'
							</div>
						</div> 
						<div class="postui post-end"></div>';

				}
			?> 
			</div>
		</div>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript">
	function buy(what,id){
		$(what).html('<img src="images/ui/loading.gif"/>');
		$.ajax({
			type: "POST",
			data: {id:id,ingame:"1"},
			url: "../ajax.php?p=itemshop_buy",
			success: function(result) {
						res = jQuery.parseJSON(result);
						if (res.error)
							$(what).addClass("error").html(res.error);
						else if (res.ok)
							$(what).addClass("ok").html(res.ok);
						else 
							$(what).addClass("error").html("Server Error! Please try again!");
					},
		});
	}
	</script>
	</body>
</html>
