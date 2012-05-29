<?php
class vote4coins extends Plugin{
	private $meta=array(
		"information" => array(
			"name" => "Vote4Coins",
			"version" => "1.0 Beta"
		),
		"requirements" => array(
			"mysql" => array(
				"hp" => array(
					"homepage" => array("vote4coins")
				)
			)
		)
	);
	private function generate(){
		global $lang,$ConfigProvider;
		$plugin_conf=$ConfigProvider->get("plugin_vote4coins");
		$settings=$ConfigProvider->get("settings");
		if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) 
			$this->add("content",array(
				"head" => array(
					"title" => $lang["misc"]["vote4coins"]
				),
				"middle" => array(
					"text" => $lang->get("vote4coins_desc",array("coins"=>$plugin_conf->get("cpv"),"time"=>ceil($plugin_conf->get("wtime")/3600)))."<br/><br/>".$lang->get("needlogin")
				)
			));
		else{
			$this->add("content",array(
				"head" => array(
					"title" => $lang["misc"]["vote4coins"]
				),
				"middle" => array(
					"text" => $lang->get("vote4coins_desc",array("coins"=>$plugin_conf->get("cpv"),"time"=>ceil($plugin_conf->get("wtime")/3600))).'<br/><br/><input type="button" class="btn" id="votebtn" value="'.$lang->get("vote").'" onclick="javascript:vote()"/><div id="voteres"></div>'.$lang->get("vote4coins_howto")
				)
			));
		}
		$this->add("jsfile","js/jquery.js");
		$this->add("js",'
		var g_v=false;
		function vote(){
			$.ajax({
			  type: "POST",
			  url: "'.$settings->get("baseurl").'ajax.php?p=vote4coins",
			  data: {v:g_v},
			  success: function (data){
			  	res = jQuery.parseJSON(data);
			  	if (res.error)
			  			$("#voteres").addClass("error").removeClass("ok").html(res.error);
			  	if (res.ok)
			  			$("#voteres").addClass("ok").removeClass("error").html(res.ok);
				if (res.btn)
					$("#votebtn").val(res.btn);
				if (res.url)
					window.open(res.url,"_blank");
				if (res.v)
					g_v=res.v;
				if (res.coins)
					$(".coins").html(res.coins);
			  },
			});
		
		}');
	}
}