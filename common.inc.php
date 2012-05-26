<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
/*
 * PHP Error handling
 * Notice here: This is supposed to be a CLEAN script
 * it will even abort on notices.
 * Keep your plugins clean!
 * Thanks
 * - iMer
 */
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new CErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

/*
 * Class Autoloading 
 */
function __autoload($name) {
 	global $config;
 	if (!isset($config)) {
 		if (!file_exists("inc/classes/".$name.".class.php")) throw new Exception("No config defined and default class dir does not exist\nClass '".$name."' does not exist");
 		
 	}
 	include($config["path"]["includes"].$config["path"]["classes"].$name.".class.php");
}
spl_autoload_register("__autoload");

/*
 * Current Page
 */
function loadp(){
	global $settings;
	if (isset($isajax)) // Ajax request are still using $_GET["p"]
		$p = ((isset($_GET["p"])&&!empty($_GET["p"]))?$_GET["p"]:"home");
	else{
		/*
		 * Using PATH_INFO
		 * URLs look like:
		 * http://examplemt2.org/index.php/home
		 */
		if (isset($_SERVER["PATH_INFO"]) && !empty($_SERVER["PATH_INFO"])){ 
			$p = substr($_SERVER["PATH_INFO"],1);
		/*
		 * Using $_GET
		 * URLs look like:
		 * http://examplemt2.org/index.php?p=home
		 */
		}elseif (isset($_GET["p"]))
			$p = ((isset($_GET["p"])&&!empty($_GET["p"]))?$_GET["p"]:"home"); // old $_GET["p"] behaviour
		/*
		 * Using my mod_rewrite stuff i threw together
		 * URLs look like:
		 * http://examplemt2.org/home
		 */
		elseif($_SERVER["REQUEST_URI"] != $_SERVER["SCRIPT_NAME"]){ // Check if page "empty"
			// Dont ask me why and how that works. I already forgot. 
			// You should probably just grab the code and try it out for yourself.
			$p = explode("?",substr($_SERVER["REQUEST_URI"],1));
			$p = $p[0];
			$urlbase = substr(substr(parse_url($settings->get("baseurl"),PHP_URL_PATH),1),0,-1);
			$p = str_replace($urlbase,"",$p);
			if (strlen($p) < 2)
				$p = "home";
			else{
				if (substr($p,-1) == "/")
					$p = substr($p,0,-1);
				if ($p[0] == "/")
					$p = substr($p,1);
				if (empty($p))
					$p = "home";
			}
		}else
			$p = "home"; //"empty"
	}
	return $p;
}
/*
 * Function for checking on valid URL (used for images and stuff)
 */ 
function isURL($url){
	return (preg_match('|^[a-z0-9-]+?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url))?true:false;
}
?>
