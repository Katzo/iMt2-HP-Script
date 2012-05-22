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
	private $BackgroundJobList = array();
	public function __construct() {
		global $p;
		$this->page = $p;
	}
	public function build() {
		global $lang,$urlmap,$p,$db,$ConfigProvider;
		$settings = $ConfigProvider->get("settings");
		include($settings->get("path","includes")."/design.inc.php"); // Pass the generated content to design.inc.php for final design echoing
		// Background Jobs
		flush(); // Flush all output to ensure the user has to full page and is able to use it, even if it's not fully loaded
		ignore_user_abort(true);  // Ingore page closing
		set_time_limit(60*60*5); // Give it a lot of time to finish the bg jobs (5hours)
		ob_start(); // Start output buffer - we don't want anymore output to be sent to the user
		foreach ($this->BackgroundJobList as $file)
			include($file); // Include all the files
		ob_end_clean(); // throw everything outputed away! :)
	}
	public function getValidAddLocations(){
		return array("lside","rside","lsidebar","rsidebar","navi","contentbox","footer","js","jsfile","bgjob","backgroundjob");
	}
	public function add($where,$what){
		switch($where){
			case "lsidebar":$this->addLSidebar($what);break;
			case "rsidebar":$this->addRSidebar($what);break;
			case "lside":$this->addLSidebar($what);break;
			case "rside":$this->addRSidebar($what);break;
			case "navi":$this->addNavi($what);break;
			case "contentbox":$this->addContentBox($what);break;
			case "content":$this->addContentBox($what);break;
			case "footer":$this->addFooter($what);break;
			case "js":$this->addJS($what);break;
			case "jsfile":$this->addJSFile($what);break;
			case "bgjob":$this->addBackgroundJob($what);break;
			case "backgroundjob":$this->addBackgroundJob($what);break;
			default:throw new CException("Tried to add element to unknown location (".$where.")!");break;
		}
	}
	public function addNavi($what) { 
		/* 
		 * Provide an array:
		 * "url" => "http://".$config["baseurl"]."/home",
		 * "text" =>  "Home",
		 * "page" => "home", // for determining the "active" page
		 * "other" => "onclick='dostuff();'"  // i don't know why you'd want that but meh. (doesnt need to be set))
		 * "loggedin" => true,  // only show when logged in or not logged in (doesnt need to be set)
		 */
		 global $ConfigProvider;
		 $settings = $ConfigProvider->get("settings");
		 if (isset($what["loggedin"]) && $what["loggedin"]!=(isset($_SESSION["user"]) && !empty($_SESSION["user"])))
		 	return; // When doesnt match, return 
		 if (is_array($what)) {
		 	if (!isURL($what["url"]))
		 		$what["url"] = $settings->get("baseurl").$what["url"];
		 	$this->navilist[]=$what;
		 }else
		 	throw new CException("I could find an array in the variable you provided :(");
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
		 * 			"more" => "http://forum.examplemt2.com/thread.php?id=123",
		 * 			"what" => "Read more"
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
			throw new CException("Tried to add the file ".$what." to the content box, but i could find it :(");
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
			throw new CException("Tried to add the file ".$what." to the left sidebar, but i could find it :(");
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
			$this->rsidebarlist[] = $what;
		else
			throw new CException("Tried to add the file ".$what." to the right sidebar, but i could find it :(");
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
		 	throw new CException("I could find an array in the variable you provided :(");
	}
	public function addJS($what) {
	 	if (!in_array($what,$this->jslist)) 
	 		$this->jslist[]=$what;
	}
	public function addJSFile($what) {
		global $ConfigProvider;
		$settings = $ConfigProvider->get("settings");
		if (!in_array($what,$this->jsfilelist)) {
	 		if (isURL($what))
	 			$this->jsfilelist[]=$what;
	 		else 
	 			$this->jsfilelist[]=$settings->get("baseurl").$what;
		}
	}
	public function addBackgroundJob($what) {
		if (!file_exists($what)) throw new CException("Tried to add the file ".$what." to the background job list, but i could find it :(");
		$this->BackgroundJobList[] = $what;
	}
	public function __destruct (){
		unset($this->lsidebarlist);
		unset($this->rsidebarlist);
		unset($this->contentboxlist);
		unset($this->navilist);
	}
}
?>