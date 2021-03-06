<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "register"
 * guess what it does.
 */
$build->addContentBox($config["path"]["includes"].$config["path"]["plugins"]."register/register.con.php");
$build->addJSFile("js/jquery.js");
$build->addJS("function regcheck(what){
	$.ajax({
	  type: 'POST',
	  url: 'ajax.php?p=regcheck',
	  data: {what:what,value:$('#'+what).val()},
	  success: function(data){
	  	res = jQuery.parseJSON(data);
	  	if (res.error) 
	  		$('#'+what+'res').addClass('error').removeClass('ok').html(res.error);
	  	else if(res.ok)
	  		$('#'+what+'res').addClass('ok').removeClass('error').html(res.ok);
	  	else
	  		$('#'+what+'res').addClass('error').removeClass('ok').html('Unknown error');
	  },
	});
}
");
?>