<?php
class Plugin {
	private $buildlist = array();
	private $meta = array(
		"information" => array(
			"name" => "Plugin Baseclass",
			"version" => "v0.1",
		),
	);
	/*
	 * $meta = array(
	 *    "information" => array(
	 *       "name" => "Example Plugin",
	 *       "version" => "0.1 Alpha",
	 *     ),
	 *    "requirements" => array(
	 *        "plugins" => array("example2","example3"),
	 *        "mysql" => array("
	 *         		"game" => array( // Connection game
	 * 					"account"=>array( // Database account
	 * 						"account" // table account
	 * 					),
	 * 					"player"=>array( // Database player
	 * 						"player_index", // Table player_index
	 * 						"player" // Table player
	 * 					),
	 * 				),
	 * 		  "),
	 *    )
	 * );
	 */
	private $lerror;
	final private function getName() {
		return $this->meta["information"]["name"];
	}
	final private function getVersion() {
		return $this->meta["information"]["version"];
	}
	private function check_requirements() {
		global $db;
		if (!isset($this->meta["requirements"])) return true;
		if (isset($this->meta["requirements"]["plugins"])) {
			global $ConfigProvider;
			$settings = $ConfigProvider->get("settings");
			foreach($this->meta["requirements"]["plugins"] as $plugin)	
				if (!file_exists($settings->get("path","include").$settings->get("path","plugin").$plugin)){
					$this->lerror="Plugin ".$plugin." does not exist! Required by ".$this->getName();
					return false;
				}
		}
		if (isset($this->meta["requirements"]["mysql_tables"])){
			foreach($this->meta["requirements"]["mysql"] as $connection => $dbarray){
				// Some ugly code for split homepage databases
				if ($connection="hp" && !isset($db->hp))
					$connection="game";
					
				if (!isset($db->$connection)){
					$this->lerror="MySQL connection '".$connection."' does not exist! Required by ".$this->getName();
					return false;
				}
				foreach($dbarray as $database => $tablearray){
					$select_db = mysql_select_db($database,$db->$connection);
					if (!$select_db) {
						$this->lerror="MySQL database '".$database."' does not exist (".$connection.")! Required by ".$this->getName();
						return false;
					}
					foreach($tablearray as $table){
						$q = mysql_query('SHOW TABLES LIKE "'.$table.'"',$db->$connection);
						if (mysql_num_rows($q) == 0) {
							$this->lerror="MySQL table '".$database.".".$table."' does not exist (".$connection.")! Required by ".$this->getName();
							return false;
						}
					}
				}
			}
		}
		return true;
	}
	private function check(){
		if (!$this->check_requirements()) throw new CException("Plugin requirements were not fullfilled!\n".$this->lerror);	
	}
	private function generate(){
		// Your generate script here
		$this->add("contentbox",array(
				"head" => array(
					"title" => "Just a quick notice",
				),
				"middle" => array(
					"text" => "Congratulations!<br/>You found out how to make plugins!\nYou should probably override the generate function though :P"
				)
			)
		);
	}
	final public function addContent() {
		$this->check();
		$this->generate();
		$this->getContent();
	}
	// Content functions
	private function add($where,$what){
		$this->buildlist[]=array($where,$what);
	}
	final private function getContent(){
		return $this->buildlist;
	}
}
?>