<?php
class error {
	public function __construct($content = "I made a mistake! :(<br/>I am so sorry this happened<br/>Please try again and contact someone when the problem persists!<br/><br/>Bye~",$title = "Help!"){
		global $settings;
		$content = str_replace("\n","<br/>",$content);
		die('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Error</title>
		'.(isset($settings)?'<link href="'.$settings["baseurl"].'css/error.css"  rel="stylesheet" type="text/css"/>"':'<style type="text/css">/*---------------------------------------------------*/
/* Script by Aziz Natour (www.aziznatour.com) -------*/
/* Modified by Sirius (www.energymt2.org) -----------*/
/*---------------------------------------------------*/
html, body, * {
	padding:0; 
	margin:0;
}

body {
	background:#000000 url("images/ui/bg.jpg") no-repeat;
	background-attachment: fixed;
	background-position: top center;
	text-align:center;
	color:#fff6cc;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
}
#wrapper{
	width:508px;
	margin:15% auto;
}
.postui {
	background:url("images/ui/content_post_ui.png");
}

	.post-title {
		height:51px;
		line-height:50px;
	}
	
	.post-end {
		background-position:left bottom;
		height:12px;
		margin-bottom:25px;
	}
	
	.post-con {
		background-position:center right;
		background-repeat:repeat-y;
		line-height:1.8;
		font-size:11px;
	}
	
		.post-title h2 {
			float:left;
			color:#ffc;
			font-size:14px;
			text-shadow:0 0 5px #ffc;
			text-indent:42px;
		}
		.con-wrap {
			padding:8px 25px;
		}
		
			.con-wrap p {
				padding-bottom:15px;
			}</style>').'
	</head>
	<body>
		<div id="wrapper">
			<div class="postui post-title"><h2>'.$title.'</h2></div>
			<div class="postui post-con">
				<div class="con-wrap">
					'.$content.'
				</div>
			</div> 
			<div class="postui post-end"></div>
		</div>
	</body>
</html>
');
	}
}
?>