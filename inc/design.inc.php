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
    <title>'.$config["settings"]["title"].'</title>
    <link rel="shortcut icon" href="/favicon.gif" />
    <link rel="icon" type="image/gif" href="/favicon.gif" />
    <link rel="stylesheet" type="text/css" media="screen" href="'.$config["settings"]["baseurl"].'css/style.css" />
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="screen" href="'.$config["settings"]["baseurl"].'css/ie7.css" /><![endif]-->
</head>
<body>
	 <div id="wrapper">
		<div id="header">
			<a id="logo" href="'.$config["settings"]["baseurl"].'" title="Logo"><img src="'.$config["settings"]["baseurl"].'images/logo/logo.png" alt="Logo" /></a>
		</div>
		<div id="navbar">
		<div class="clearfix"></div>
			<ul>';
foreach ($this->navilist as $ar) 
	echo '<li><a '.(($ar["page"] == $this->page)?'class="current"':'').' href="'.$ar["url"].'"'.((isset($ar["other"]))?" ".$ar["other"]." ":"").'>'.$ar["text"].'</a></li>';
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
unset($ar);
if (isset($cont))
	foreach ($cont as $ar)
		if (isset($ar["plain"]))
			echo $ar["plain"];
		else
			echo '
					<div class="postui post-title">
						<h2>'.$ar["head"]["title"].'</h2>
						'.((isset($ar["head"]["date"]))?'<span class="date">'.$ar["head"]["date"].'</span>':'').'
					</div>
					<div class="postui post-con">
						<div class="con-wrap">
							<p>'.((isset($ar["middle"]["img"]))?'<img class="thumb" src="'.(isURL($ar["middle"]["img"]["src"])?$ar["middle"]["img"]["src"]:$config["settings"]["baseurl"].$ar["middle"]["img"]["src"]).'" alt="'.$ar["middle"]["img"]["alt"].'" />':'').$ar["middle"]["text"].'</p>
							'.((isset($ar["footer"]))?'<div class="sep"></div>'.((isset($ar["footer"]["more"])&&isset($ar["footer"]["what"]))?'<a href="'.$ar["footer"]["more"].'" class="more">'.$ar["footer"]["what"].'</a>':'').((isset($ar["footer"]["plain"]))?$ar["footer"]["plain"]:''):'').'
						</div>
					</div> 
					<div class="postui post-end"></div>'; 
echo '</div><div class="sidebar" id="sidebar-right">';
unset($ar);
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
				<p><a href="https://github.com/imermcmaps/iMt2-HP-Script">iMt2 HP Script</a> by <a href="http://imer.cc">iMer</a> &middot; Design by <a href="http://www.aziznatour.com">Aziz Natour</a> &amp; <a href="http://energymt2.org/">Sirius</a></p>
			</div>
			<div class="right">';
			foreach ($this->footerlist as $ar)
				echo '<a href="'.$ar["url"].'"'.((isset($ar["other"]))?" ".$ar["other"]." ":"").'">'.$ar["text"].'</a>';
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