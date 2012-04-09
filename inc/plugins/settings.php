<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called settings
 * It is basically a usercp where you can change your password and stuff.
 */
$build->addContentBox($config["path"]["includes"].$config["path"]["plugins"]."settings/settings.con.php");
$build->addJSFile("js/jquery.js");
$build->addJSFile("js/common.js");
$build->addJS("function ssubmit(what,rese){
	asubmit(what,'ajax.php?p=settings',function (data){res =jQuery.parseJSON(data);if(res.error) $(rese).addClass('error').html(res.error); else if(res.ok) $(rese).addClass('ok').html(res.ok); else $(rese).addClass('error').html('Unknown error! HELP!');});
}");
?>