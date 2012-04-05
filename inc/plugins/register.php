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
$build->addJS("function regcheck(what){
	$.ajax({
	  type: 'POST',
	  url: 'ajax.php?p=regcheck',
	  data: {what:what,value:$('#'+what).val()},
	  success: function(data){
	  	res = jQuery.parseJSON(data);
	  	if (res.error) 
	  		$('#'+what+'res').addClass('error').html(res.error);
	  	else if(res.ok)
	  		$('#'+what+'res').addClass('ok').html(res.ok);
	  	else
	  		$('#'+what+'res').addClass('error').html('Unknown error');
	  },
	});
}
}");
?>