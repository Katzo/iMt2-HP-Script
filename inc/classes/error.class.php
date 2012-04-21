<?php
class Error {
	public function __construct($content = "I made a mistake! :(<br/>I am so sorry this happened<br/>Please try again and contact someone when the problem persists!<br/><br/>Bye~",$title = "Help!"){
		die('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Error</title>
		<link href="css/error.css" rel="stylesheet" type="text/css"/>
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