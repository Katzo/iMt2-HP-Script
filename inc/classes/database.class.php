<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
class database {
	private $conlist = array();
	public function __construct() {
		global $config;
		foreach ($config["db"] as $name => $dbconfig)
			if (!$this->create($name,$dbconfig)) throw new Exception("I could not connect to the database connection ".$name."! :/".mysql_error());
	}
	public function create($name,$config) {
		try {
			$this->$name = mysql_connect($config["host"],$config["user"],$config["pass"]);
		}
		catch (ErrorException $e) {}
		if (!isset($this->$name)||!$this->$name) return false;
		$this->conlist[] =$name;
		$name .="db";
		$this->$name = $config["db"];
		return true;
	}
	public function __destruct() {
		foreach ($this->conlist as $conname)
			mysql_close($this->$conname);
	}
}
?>