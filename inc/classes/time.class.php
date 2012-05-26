<?php
class time{
	private $time;
	public function __construct($time){
		$this->time=$time;
	}
	public function tostr() {
		global $lang;
		$dif = time()-$this->time;
		$future=false;
		if ($dif < 0){
			$future=true;
			$dif*=-1;
		}
		// Seconds
		if ($dif < 60)
			return $lang->get("time_now");
		// We're just going to ignore that 59 seconds isn't "now"
		
		// Minutes
		$minutes = floor($dif/60);
		if ($minutes<4)
			return $lang->get(($future)?"time_fformat":"time_format",array(
				"ago" => ($future)?$lang->get("time_in"):$lang->get("time_a"),
				"value"=>$lang->get("time_af"),
				"time"=>$lang->get("time_m"),
				"at" => ""
			));
		if ($minutes<60)
			return $lang->get(($future)?"time_fformat":"time_format",array(
				"ago" => ($future)?$lang->get("time_in"):$lang->get("time_a"),
				"value"=>$minutes,
				"time"=>$lang->get("time_m"),
				"at" => ""
			));
		// Hours
		$hours=floor($dif/3600);
		if ($hours == 1) 
		return $lang->get(($future)?"time_fformat":"time_format",array(
				"ago" => ($future)?$lang->get("time_in"):$lang->get("time_a"),
				"value"=>1,
				"time"=>$lang->get("time_H"),
				"at" => ""
			));
		if ($hours < 24)
			return $lang->get(($future)?"time_fformat":"time_format",array(
				"ago" => ($future)?$lang->get("time_in"):$lang->get("time_a"),
				"value"=>$hours,
				"time"=>$lang->get("time_h"),
				"at" => ""
			));
		// Days
		$days=floor($hours/24);
		if ($days == 1)
			return $lang->get(($future)?"time_fformat":"time_format",array(
				"ago" => "",
				"value"=>"",
				"time"=>($future)?$lang->get("time_tmrw"):$lang->get("time_ystrd"),
				"at" => $lang->get("time_at")." ".date("H:m")
			));
		if ($days < 7)
			return $lang->get(($future)?"time_fformat":"time_format",array(
				"ago" => ($future)?$lang->get("time_in"):$lang->get("time_a"),
				"value"=>$days,
				"time"=>$lang->get("time_d"),
				"at" => $lang->get("time_at")." ".date("H:m")
			));
		return date($lang->get("time_dformat"),$this->time);
	}
	public function vtostr($time){ // Time value to string
		global $lang;
		$days = floor($time/86400);
		$r = $time%86400;
		$hours = floor($r/3600);
		$r = $r%3600;
		$minutes = ceil($r/60);
		if ($days > 0)
			$str .= $days." ".($days==1?$lang["time"]["D"]:$lang["time"]["d"])." ";
		if ($hours > 0)
			$str .= $hours." ".($hours==1?$lang["time"]["H"]:$lang["time"]["h"])." ";
		if ($minutes > 0)
			$str .= $minutes." ".($minutes==1?$lang["time"]["M"]:$lang["time"]["m"])." ";
		return $str;
	}
}
?>