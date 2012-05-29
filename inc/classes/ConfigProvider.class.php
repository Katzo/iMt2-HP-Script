<?php
class ConfigProvider{
	private $loaded = array();
	/*
	 * get($name) where $name is the name of the config you want to get
	 */
	public function get($name) { 
		global $db;
		// If the config was already loaded it doesnt need to load it again - just return the same class that was returned before :)
		if (isset($this->loaded[$name])) return $this->loaded[$name];
		// Check if config already has a chached version
		if (file_exists("config/".$name.".cacheconfig.php")){
			if (!is_readable("config/".$name.".cacheconfig.php")) throw new CException("No permission to read 'config/".$name.".cacheconfig.php'");
			$chandle = fopen("config/".$name.".cacheconfig.php","r");
			$string = "";
			while (!feof($chandle))
				$string .=fread($chandle,1024);
			$this->loaded[$name] = new config($this->parse($string),array("name"=>$name));
			return $this->loaded[$name];
		}else{
			// In case the config file does not exist we will try to create it
			if (isset($db->hp))
				$q = mysql_query("SELECT config FROM ".$db->hpdb["homepage"].".config WHERE name='".$name."' LIMIT 1",$db->hp); 
			else
				$q = mysql_query("SELECT config FROM ".$db->gamedb["homepage"].".config WHERE name='".$name."' LIMIT 1",$db->game); 
			if (!$q) throw new CException("Invalid Query!\n".mysql_error((isset($db->hp)?$db->hp:$db->game)));
			$string = mysql_fetch_object($q);
			if (!$string) throw new CException("Could not load the config for ".$name.".\nNo cached config and no database entry!");
			$string = $string->config;
			$this->build_file($name,$string);
			$this->loaded[$name] = new config($this->parse($string),array("name"=>$name));
			$this->loaded[$name]->save(false);
			return $this->loaded[$name];
		}
	}
	private function parse($string,$file=true){
		if ($file){
			$string = explode("\n",$string);
			// First line is just an exit surrounded by php tags - we dont want that in our config ;)
			$string=$string[1];
		}
		$dec = json_decode($string,true);
		if ($dec == null) throw new CException("Unable to parse config!");
		return $dec;
	}
}
?>