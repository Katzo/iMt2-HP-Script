<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called itemshop
 * It helps you to make money with your server. (When you make enough money please consider donating to help me make more stuff like this!)
 * You can offer packages and single items.
 */
class plugin_itemshop extends Plugin{
	private $meta=array(
		"information"=>array(
			"name" => "Itemshop",
			"version"=>"1.0 Beta"
		),
		"requirements" => array(
			"mysql"=>array(
				"hp"=>array(
					"homepage" => array("itemshop_category","itemshop_package","itemshop_item")
				),
				"game"=>array(
					"player" => array("item_award"),
					"account"=> array("account"),
				)
			)
		)
	);
	private function generate(){
		global $lang,$db,$ConfigProvider,$urlmap;
		$this->add("jsfile","js/jquery.js");
		$this->add("jsfile","js/common.js");
		$settings=$ConfigProvider->get("settings");
		$this->add("js",'function buy(what,id){
			$(what).html(\'<img src="'.$settings["settings"]["baseurl"].'images/ui/loading.gif"/>\');
			$.ajax({
				type: "POST",
				data: {id:id},
				url: "ajax.php?p=itemshop_buy&json",
				success: function(result) {
							res = jQuery.parseJSON(result);
							if (res.coins) $(".coins").html(res.coins);
							if (res.error)
								$(what).addClass("error").html(res.error);
							else if (res.ok)
								$(what).addClass("ok").html(res.ok);
							else 
								$(what).addClass("error").html("Server Error! Please try again!");
						},
			});
		}');
		$plugin_conf=$ConfigProvider->get("plugin_itemshop");
		if (isset($db->hp))
			$q = mysql_query('SELECT id,name FROM '.$db->hpdb["homepage"].'.itemshop_category WHERE enabled=1',$db->hp);
		else
			$q = mysql_query('SELECT id,name FROM '.$db->gamedb["homepage"].'.itemshop_category WHERE enabled=1',$db->game);
		$cat = '';
		while ($res = mysql_fetch_object($q))
			$cat.='<input type="button" onclick="location.href=\''.$urlmap["itemshop"].(!isUrl($urlmap["itemshop"]) && substr($urlmap["itemshop"],0,1) == "?"?"&":"?").'cat='.$res->id.'\'"class="btn classbtn" value="'.$res->name.'"/>';
		$this->add("content",array(
			"head" => array(
				"title" => $lang->get("itemshop")
			),
			"middle" => array(
				"text" => '<div style="text-align:center;">'.(isset($_SESSION["user"]) && !empty($_SESSION["user"])?$lang->get("youcoin",array("coinname"=>($_SESSION["coins"]==1)?$lang->get("coin"):$lang->get("coins"),"coins"=>$_SESSION["coins"])).' <a href="'.$urlmap["donate"].'">'.$lang->get("donate").'?</a>
					<div class="sep"></div>':'').'<div style="margin:auto;">'.$cat.'</div></div>'
			)
		));
		if (isset($_GET["cat"])&&!empty($_GET["cat"]))
			if (isset($db->hp))
				$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->hpdb["homepage"].'.itemshop_package WHERE enabled=1 and cat="'.mysql_real_escape_string($_GET["cat"]).'"',$db->hp);
			else
				$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->gamedb["homepage"].'.itemshop_package WHERE enabled=1 and cat="'.mysql_real_escape_string($_GET["cat"]).'"',$db->game);	
		else
			if (isset($db->hp))
				$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->hpdb["homepage"].'.itemshop_package WHERE enabled=1 ORDER BY added DESC LIMIT '.$plugin_conf->get("newest_count"),$db->hp);
			else
				$q = mysql_query('SELECT id,name,`desc`,img,price FROM '.$db->gamedb["homepage"].'.itemshop_package WHERE enabled=1 ORDER BY added DESC LIMIT '.$plugin_conf->get("newest_count"),$db->game);
		$items=false;	
		while ($res = mysql_fetch_object($q)) {
			$this->add("content",array(
				"head" => array(
					"title" => $res->name,
				),
				"middle" => array(
					"img" => array("src" => $res->img,"alt" => $res->name),
					"text" => $res->desc,
				),
				"footer" => array(
					"plain" => $lang->get("itemshop_price").': <b>'.$res->price.'</b> '.($res->price==1?$lang->get("coin"):$lang->get("coins")).(isset($_SESSION["user"])&&!empty($_SESSION["user"])?' <span class="right"><a onclick="javascript:buy($(this).parent(),'.$res->id.');return false;" class="more">'.$lang->get("itemshop_buy").'</a></span>':'')
				)
			));
			$items=true;
		}
		if (!$items);
			$this->add("content",array(
				"head" => array(
					"title"=> $lang->get("itemshop"),
				),
				"content"=>array(
					"text" => $lang->get("itemshop_404")
				)
			));
	}
}