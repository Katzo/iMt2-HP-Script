<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>'.$this->config["settings"]["title"].'</title>
    <link rel="shortcut icon" href="favicon.gif" />
    <link rel="icon" type="image/gif" href="favicon.gif" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="screen" href="css/ie7.css" /><![endif]-->
</head>
<body>
	 <div id="wrapper">
		<div id="header">
			<a id="logo" href="'.$this->config["settings"]["baseurl"].'" title="Logo"><img src="images/logo/logo.png" alt="Logo" /></a>
		</div>
		<div id="navbar">
		<div class="clearfix"></div>
			<ul>';
foreach ($this->navilist as $ar) 
	echo '<li><a '.(($ar["page"] == $this->page)?'class="current"':'').' href="'.$ar["url"].((isset($ar["other"]))?$ar["other"]:"").'">'.$ar["text"].'</a></li>';
echo '			</ul>		
		</div>
		<hr class="hr" />
		<div id="main">
			<div class="mui mtop"></div>
			<div class="mui mcon">
				<div class="sidebar" id="sidebar-left">';
if (isset($lsb))
	foreach ($lsb as $ar)
		if (isset($ar["plain"]))
			echo $ar["plain"];
		else
			echo '<div class="sb-title"><h3>'.$ar["head"]["title"].'</h3></div>
						<div class="sb-con">
						'.$ar["middle"]["text"].'
						</div>
						<div class="sb-end"></div>';
echo '				</div>
				<div id="content">';
if (isset($con))
	foreach ($con as $ar)
		if (isset($ar["multi"])) {
			unset($ar["multi"]);
			foreach($ar as $ar2) {
			echo '<div class="postui post-con">
					<div class="postui post-title">
						<h2>'.$ar2["head"]["title"].'</h2>
						'.((isset($ar2["head"]["date"]))?'<span class="date">by admin on June 29, 2010</span>':'').'
					</div>
					<div class="postui post-con">
						<div class="con-wrap">
							<p>'.((isset($ar2["middle"]["img"]))?'<img class="thumb" src="'.$ar2["middle"]["img"]["src"].'" alt="'.$ar2["middle"]["img"]["alt"].'" />':'').$ar2["middle"]["text"].'</p>
							'.((isset($ar2["footer"]))?'<div class="sep"></div>'.((isset($ar2["footer"]["more"]))?'<a href="#" class="more">Read More</a>':$ar2["footer"]["plain"]):'').'
						</div>
					</div> 
					<div class="postui post-end"></div>
				  </div>'; 
			}
		}
		if (isset($ar["plain"]))
			echo $ar["plain"];
		else
			echo '<div class="postui post-con">
					<div class="postui post-title">
						<h2>'.$ar["head"]["title"].'</h2>
						'.((isset($ar["head"]["date"]))?'<span class="date">by admin on June 29, 2010</span>':'').'
					</div>
					<div class="postui post-con">
						<div class="con-wrap">
							<p>'.((isset($ar["middle"]["img"]))?'<img class="thumb" src="'.$ar["middle"]["img"]["src"].'" alt="'.$ar["middle"]["img"]["alt"].'" />':'').$ar["middle"]["text"].'</p>
							'.((isset($ar["footer"]))?'<div class="sep"></div>'.((isset($ar["footer"]["more"]))?'<a href="#" class="more">Read More</a>':$ar["footer"]["plain"]):'').'
						</div>
					</div> 
					<div class="postui post-end"></div>
				  </div>'; 
echo '</div><div class="sidebar" id="sidebar-right">';
if (isset($rsb))
	foreach ($rsb as $ar)
		if (isset($ar["plain"]))
			echo $ar["plain"];
		else
			echo '<div class="sb-title"><h3>'.$ar["head"]["title"].'</h3></div>
						<div class="sb-con">
						'.$ar["middle"]["text"].'
						</div>
						<div class="sb-end"></div>';
echo '</div>			<div class="clear"></div>
			</div>
			<div class="mui mend"></div>
		</div>

		<hr class="hr" />
		<div id="footer">
			<div class="left">
				<p><a href="https://github.com/imermcmaps/iMt2-HP-Script">iMt2 Hp Script</a> by <a href="http://imer.cc">iMer</a></p>
			</div>
			<div class="right">';
			foreach ($this->footerlist as $ar)
				echo '<a href="'.$ar["url"].((isset($ar["other"]))?$ar["other"]:"").'">'.$ar["text"].'</a>';
			echo '</div>		
		</div>
	 </div>';
foreach ($this->jsfilelist as $ar) 
	echo '<script type="text/javascript" src="'.$ar.'"></script>';
foreach ($this->jslist as $ar) 
	echo '<script type="text/javascript">'.$ar.'</script>';
	
echo '
</body>
</html>';
?>