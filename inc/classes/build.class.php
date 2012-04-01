<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
class build {
	private $lsidebarlist = array();
	private $rsidebarlist = array();
	private $contentboxlist = array();
	private $navilist = array();
	private $footerlist = array();
	private $jslist = array();
	private $jsfilelist = array();
	private $config;
	public function __construct($config) {
		global $config;
		$this->config = $config;
		$this->page = (isset($_GET["p"])&&!empty($_GET["p"])?$_GET["a"]:"home");
	}
	public function build() {
		$db = new database;
		$lsb = array();
		$cont = array();
		$srb = array();
		foreach ($this->lsidebarlist as $file) {
			$content = false;
			include($file);
			if (!is_array($content)) $this->error("The file ".$file." didnt produce any kind of array :(");
			$lsb[] = $content;
		}
		foreach ($this->rsidebarlist as $file) {
			$content = false;
			include($file);
			if (!is_array($content)) $this->error("The file ".$file." didnt produce any kind of array :(");
			$rsb[] = $content;
		}
		foreach ($this->contentboxlist as $file) {
			$content = false;
			include($file);
			if (!is_array($content)) $this->error("The file ".$file." didnt produce any kind of array :(");
			$cont[] = $content;
		}
		include($this->config["path"]["includes"]."/design.inc.php"); // Pass the generated content to design.inc.php for final design echoing
	}
	public function addNavi($what) { 
		/* 
		 * Provide an array:
		 * "url" => "http://".$config["baseurl"]."/home",
		 * "text" =>  "Home",
		 * "page" => "home", // for determining the "active" page
		 * "other" => "onclick='dostuff();'"  // i don't know why you'd want that but meh. (doesnt need to be set))
		 */
		 if (is_array($what)) 
		 	$this->navilist[]=$what;
		 else
		 	$this->error("I could find an array in the variable you provided :(");
	}
	public function addContentBox($what) {
		/* 
		 * Provide an array to the file for generating the content (will be included)
		 * It needs to generate following var:
		 * $content = array(
		 * 		"head" => array(
		 * 			"title" => "News",
		 * 			"date" => "by admin on June 29, 2010" // doesnt need to be set
		 * 		),
		 * 		"middle" => array(
		 * 			"text" => "Bla bla bla..", // This is plain text (can contain html and such)
		 * 			"img" => array("src" => "img/news_01.png","alt" => "News 1") // doesnt need to be set
		 * 		)
		 * 		"footer" => array(  // doesnt need to be set
		 * 			"more" => "http://forum.examplemt2.com/thread.php?id=123"
		 * 			 // OR
		 * 			"plain" => "<img src='stuff.png'/>"
		 * 		)
		 * )
		 * it can alternatively provide this:
		 * $content = array(
		 * 		"plain" => "<div class='fanybox'>Somestuff :D</div>"
		 * )
		 * Pro tip: This causes it to output $content["plain"]
		 * 
		 */
		if (file_exists($what))
			$this->contentboxlist[] = $what;
		else
			$this->error("Tried to add the file ".$what." to the content box, but i could find it :(");
	}
	public function addLSidebar($what) {
		/* 
		 * Provide an array to the file for generating the content (will be included)
		 * It needs to generate following var:
		 * $content = array(
		 * 		"head" => array(
		 * 			"title" => "News",
		 * 		),
		 * 		"middle" => array(
		 * 			"text" => "Bla bla bla..", // This is plain text (can contain html and such)
		 * 		)
		 * )
		 * it can alternatively provide this:
		 * $content = array(
		 * 		"plain" => "<div class='fanybox'>Somestuff :D</div>"
		 * )
		 * Pro tip: This causes it to output $content["plain"]
		 * 
		 */
		if (file_exists($what))
			$this->lsidebarlist[] = $what;
		else
			$this->error("Tried to add the file ".$what." to the left sidebar, but i could find it :(");
	}
	public function addRSidebar($what) {
		/* 
		 * Provide an array to the file for generating the content (will be included)
		 * It needs to generate following var:
		 * $content = array(
		 * 		"head" => array(
		 * 			"title" => "News",
		 * 		),
		 * 		"middle" => array(
		 * 			"text" => "Bla bla bla..", // This is plain text (can contain html and such)
		 * 		)
		 * )
		 * it can alternatively provide this:
		 * $content = array(
		 * 		"plain" => "<div class='fanybox'>Somestuff :D</div>"
		 * )
		 * Pro tip: This causes it to output $content["plain"]
		 * 
		 */
		if (file_exists($what))
			$this->lsidebarlist[] = $what;
		else
			$this->error("Tried to add the file ".$what." to the right sidebar, but i could find it :(");
	}
	
	public function addFooter($what) {
		/* 
		 * Provide an array:
		 * "url" => "http://".$config["baseurl"]."/home",
		 * "text" =>  "Home",
		 * "other" => "onclick='dostuff();'"  <- i don't know why you'd want that but meh. (doesnt need to be set))
		 */
		 if (is_array($what)) 
		 	$this->navilist[]=$what;
		 else
		 	$this->error("I could find an array in the variable you provided :(");
	}
	public function addJS($what) {
	 	if (!in_array($what,$this->jslist)) 
	 		$this->jslist[]=$what;
	}
	public function addJSFile($what) {
	 	$this->jsfilelist[]=$what;
	}
	
	public function __destruct (){
		unset($this->lsidebarlist);
		unset($this->rsidebarlist);
		unset($this->contentboxlist);
		unset($this->navilist);
	}
	private function error($what) {
		die("<h1>I made a mistake! Help!</h1>".$what);
	}
}
?>