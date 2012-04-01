<?php
/*    $sql= 'DESC table_name;';
    mysql_query($sql,$con);
    if (mysql_errno()==1146){
    //table_name doesn't exist
    }
    elseif (!mysql_errno()) // bla code
    //table exist*/
$q = mysql_query("SELECT id,name,level,job FROM ".$db->gamedb["player"].".player ORDER BY level DESC",$db->game);
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
		mysql_query("INSERT INTO ".$db->hpdb["homepage"].".ranking_cache_new VALUES('".$i."','".$jr."','".$id."','".$name."','".$job."','".time()."')",$db->hp);
	else
		mysql_query("INSERT INTO ".$db->gamedb["homepage"].".ranking_cache_new VALUES('".$i."','".$jr."','".$id."','".$name."','".$job."','".time()."')",$db->game);
}
?>