<?php
class lang{
	private $list;
	public function __construct($list,$settings) {
		if (!is_array($list)) throw new CException("Provided language list is no array!");
		$this->list = $list;
	}
	public function get($what,$replacearray=false){
		if (!isset($this->list[$what])) throw new CException("Could not find '".$what."' in the language variables!");
		$out = $this->list[$what];
		if ($replacearray) {
			foreach ($replacearray as $v => $string)
				$out = str_replace("%".$v,$string,$out);
		}
		return $out;
	}
}
?>