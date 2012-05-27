<?php
class config{
	private $config;
	private $meta;
	private $modified=false;
	public $lerror;
	public function __construct($config,$meta){
		if (!isset($meta["name"])) throw new CException("meta[name] is not set <- this is a serious problem!");
		$this->config = $config;
		$this->meta = $meta;
	}
	/*
	 *  Get a config element
	 * get($what) will return config[$what]
	 * get($what,$sub) will return config[$what][$sub]
	 * and so on
	 */
	public function get($what,$sub = false,$sub2 = false,$sub3=false) {
		if ($sub3){
			if (isset($this->config[$what][$sub][$sub2][$sub3]))
				return $this->config[$what][$sub][$sub2][$sub3];
			else 
				return false;
		}
		if ($sub2){
			if (isset($this->config[$what][$sub][$sub2]))
				return $this->config[$what][$sub][$sub2];
			else 
				return false;
		}
		if ($sub){
			if (isset($this->config[$what][$sub]))
				return $this->config[$what][$sub];
			else 
				return false;
		}
		if (isset($this->config[$what]))
			return $this->config[$what];
		else 
			return false;
	}
	/*
	 *  Set a config element
	 * set($value,$what) will set config[$what]=$value
	 * set($value,$what,$sub) will set config[$what][$sub]=$value
	 * and so on
	 */
	public function set($value,$what,$sub = false,$sub2 = false,$sub3=false) {
		$modified=true;
		if ($sub3)
			$this->config[$what][$sub][$sub2][$sub3]=$value;
		if ($sub2)
			$this->config[$what][$sub][$sub2]=$value;
		if ($sub)
			$this->config[$what][$sub]=$value;
		$this->config[$what]=$value;
	}
	/*
	 * Save the config
	 */
	public function save($todb=true){
		$enc = json_encode($this->config);
		if ($todb){
			global $db;
			if (isset($db->hp))
				$q = mysql_query('REPLACE INTO '.$db->hpdb["homepage"].'.config (name,config) VALUES("'.$this->meta["name"].'","'.$enc.'")');
			else
				$q = mysql_query('REPLACE INTO '.$db->hpdb["homepage"].'.config (name,config) VALUES("'.$this->meta["name"].'","'.$enc.'")');
		}
		if(!is_writable("config/".$this->meta["name"].".cacheconfig.php")) 
			throw new CException("Config file 'config/".$this->meta["name"].".cacheconfig.php' is not writeable!");
		else{
			$chandle = fopen("config/".$this->meta["name"].".cacheconfig.php","w");
			$success = fwrite($chandle,"<?php exit; ?>\n".$enc);
			if ($success === false) throw new CException("Could not write config to file 'config/".$this->meta["name"].".cacheconfig.php'");
			else return true;
		}
	}
}
?>