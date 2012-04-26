<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called vote4coins
 * It allowes users.. well.. to vote.. for coins..
 */
$build->addContentBox($config["path"]["includes"].$config["path"]["plugins"]."vote4coins/vote4coins.con.php");
$build->addJSFile("js/jquery.js");
$build->addJS('
var g_v=false;
function vote(){
	$.ajax({
	  type: "POST",
	  url: "'.$config["settings"]["baseurl"].'ajax.php?p=vote4coins",
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
	  },
	});
	g_v=!g_v;
}');
?>