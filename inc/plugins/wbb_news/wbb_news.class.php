<?php
class plugin_wbb_news extends Plugin{
	private $meta=array(
		"information" => array(
			"name" => "Wbb News",
			"version" => "1.0"
		) 
	);
	public function __construct(){
		global $ConfigProvider;
		$plugin_conf = $ConfigProvider->get("plugin_wbb_news");
		$this->meta["requirements"]=array(
			"mysql" => array(
				$plugin_conf->get("wbbcon")=>array(
					$plugin_conf->get("wbbdb")=>array("wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board","wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread")
				)
			)
		);
		// I know this is not perfect. whatever
	}
	private function generate(){
		global $db,$ConfigProvider,$lang;
		$plugin_conf=$ConfigProvider->get("plugin_wbb_news");
		if (!isset($db->$plugin_conf->get("wbbcon"))) throw new CException("I could not find the database connection ".$plugin_conf->get("wbbcon"));
		$wbbdb = $plugin_conf->get("wbbcon")."db";
		if (!array_key_exists("board",$db->$wbbdb)) throw new CException("I could not find the database index board");
		if (is_array($plugin_conf->get("id"))){
			$qstr ="";
			foreach($plugin_conf->get("id") as $i)
				$qstr .= "(wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.parentID = '".$i."' or wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.boardID = '".$i."') OR";
			$qstr = substr($qstr,0,-2);
			$q = mysql_query("SELECT threadID,topic,firstPostPreview,userID,username,wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread.time FROM ".$db->{$wbbdb}["board"].".wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread JOIN ".$db->{$wbbdb}["board"].".wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board ON wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread.boardID = wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.boardID OR wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread.boardID = wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.parentID WHERE (".$qstr.") and isDeleted=0 ORDER BY time DESC LIMIT ".$plugin_conf->get("count"));
		}else
			$q = mysql_query("SELECT threadID,topic,firstPostPreview,userID,username,wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread.time FROM ".$db->{$wbbdb}["board"].".wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread JOIN ".$db->{$wbbdb}["board"].".wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board ON wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread.boardID = wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.boardID OR wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_thread.boardID = wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.parentID WHERE wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.parentID = '".$plugin_conf->get("id")."' or wbb".$plugin_conf->get("boardid")."_".$plugin_conf->get("installationid")."_board.boardID = '".$plugin_conf->get("id")."' and isDeleted=0 ORDER BY time DESC LIMIT ".$plugin_conf->get("count"));
		while ($res = mysql_fetch_object($q)){
			$time=new time($res->time);
			$this->add("content",array(
				"head" => array(
					"title" => htmlentities($res->topic),
					"date" => $lang->get("by").' <a href="'.$plugin_conf->get("boardurl").'?page=User&userID='.$res->userID.'">'.$res->username.'</a>, '.$time->tostr().'',
				),
				"middle" => array(
					"text" => str_replace("\n","<br/>",str_replace("€","&euro;",htmlentities($res->firstPostPreview,ENT_COMPAT,"ISO-8859-15")))
				), 
				"footer" => array(
					"more" => $plugin_conf->get("boardurl").'?page=Thread&threadID='.$res->threadID,
					"what" => $lang->get("read_more")
				)
			));
		}

	}
}