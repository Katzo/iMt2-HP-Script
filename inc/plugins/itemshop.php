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
$build->addContentBox($config["path"]["includes"].$config["path"]["plugins"]."itemshop/itemshop.con.php");
$build->addJSFile("js/jquery.js");
$build->addJSFile("js/common.js");
$build->addJS('function buy(what,id){
	$(what).html(\'<img src="'.$config["settings"]["baseurl"].'images/ui/loading.gif"/>\');
	$.ajax({
		type: "POST",
		data: {id:id},
		url: "ajax.php?p=itemshop_buy",
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
?>