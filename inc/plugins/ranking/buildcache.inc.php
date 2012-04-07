<?php
/*    $sql= 'DESC table_name;';
    mysql_query($sql,$con);
    if (mysql_errno()==1146){
    //table_name doesn't exist
    }
    elseif (!mysql_errno()) // bla code
    //table exist*/
$q = mysql_query("SELECT id,name,level,job FROM ".$db->gamedb["player"].".player ORDER BY level DESC,exp DESC",$db->game); // do fancy join ranking_cache and check for time. it'll be overly complicated for split connections :/
$i=0; // General
$wi=0; // Warrior
$ai=0; // Assasin (spelling..)
$sui=0; // Sura
$sai=0; // Shaman
while ($res = mysql_fetch_object($q)) {
	$i++;
	if ($res->job == 0 || $res->job == 4) {
		$wi++;
		$jr = $wi;
	}
	if ($res->job == 1 || $res->job == 5) {
		$ai++;
		$jr = $ai;
	}
	if ($res->job == 2 || $res->job == 6) {
		$sui++;
		$jr = $sui;
	}
	if ($res->job == 3 || $res->job == 7) {
		$sai++;
		$jr = $sai;
	}
	if (isset($db->hp))
		mysql_query("REPLACE INTO ".$db->hpdb["homepage"].".ranking_cache VALUES('".$i."','".$jr."','".$id."','".$name."','".$job."','".time()."')",$db->hp);
	else
		mysql_query("REPLACE INTO ".$db->gamedb["homepage"].".ranking_cache VALUES('".$i."','".$jr."','".$id."','".$name."','".$job."','".time()."')",$db->game);
}
if (isset($db->hp))
	mysql_query("ALTER TABLE ".$db->hpdb["homepage"]."ranking_cache comment='".time()."'",$db->hp);
else
	mysql_query("ALTER TABLE ".$db->gamedb["homepage"]."ranking_cache comment='".time()."'",$db->game);
?>