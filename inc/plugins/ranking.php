<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "ranking"
 * guess what it does.
 */
$build->addContentBox($config["path"]["includes"].$config["path"]["plugins"]."ranking/ranking.con.php");
$build->addJSFile("js/jquery.js");
$build->addJS("var g_rpage=1;
var g_rjob=-1;
var g_rname='';
function ranking(){
	$('#rloading').fadeIn(100);
	$.ajax({
		type: 'POST',
		url: 'ajax.php?p=ranking',
		data: {page:g_rpage,job:g_rjob,name:g_rname},
		success: function(data){
			$('#rankingres').html(data);
		},
	});
	$('#rloading').fadeOut(100);
}
ranking();");
?>