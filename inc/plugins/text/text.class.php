<?php
class plugin_text extends Plugin{
	private $meta = array(
		"information"=>array(
			"name" => "Text",
			"version"=>"1.0"
		),
	);
	private function generate(){
		global $ConfigProvider,$p;
		$plugin_conf=$ConfigProvider->get("plugin_text");
		foreach($plugin_conf->get($p) as $where => $what)
			$this->add($where,$what);
	}
}
?>