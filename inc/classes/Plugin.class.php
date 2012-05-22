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
	 *        "plugins" => array("example2","example3")
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
		return true;
	}
	private function check(){
		if (!$this->check_requirements()) throw new CException("Plugin requirements were not fullfilled!<br/>".$this->lerror);	
	}
	private function generate(){
		// Your generate script here
		$this->add("contentbox",array(
				"head" => array(
					"title" => "Just a quick notice",
				),
				"middle" => array(
					"text" => "Congratulations!<br/>You found out how to make plugins!<br/>You should probably override the generate function though :P"
				)
			)
		);
	}
	final public function addContent() {
		$this->check();
		$this->generate();
	}
	// Content functions
	private function add($where,$what){
		global $build;
		if (!in_array($where,$build->getValidAddLocations())) throw new CException("Tried to add element to invalid Location(".$where.")<br/>Plugin: ".$this->getName()."<br/>Outdated Version?");
		$build->add($where,$what);
	}
}
?>