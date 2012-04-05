<?php
if (!isset($_POST["what"]) || empty($_POST["what"])) exit;
include($config["path"]["includes"].$config["path"]["plugins"]."register/config.inc.php");
switch ($_POST["what"]){
	case "user":
		if (strlen($_POST["value"]) < $plugin_conf["minuserlen"])
       		die(json_encode(array("error" => str_replace("%len",$plugin_conf["minuserlen"],$lang["reg"]["userminlen_error"]))));
        if (strlen($_POST["value"]) > $plugin_conf["maxuserlen"])
           	die(json_encode(array("error" => str_replace("%len",$plugin_conf["maxuserlen"],$lang["reg"]["usermaxlen_error"]))));
        $q = mysql_query('SELECT id FROM '.$db->gamedb["account"].'.account WHERE login="'.mysql_real_escape_string($_POST["value"]).'" LIMIT 1',$db->game);	
		if (mysql_num_rows($q))
			die(json_encode(array("error" => $lang["reg"]["account_exists"])));
		die(json_encode(array("ok" => $lang["misc"]["ok"])));
		break;
	case "email":
		if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})^", $_POST["value"])) 
           	die(json_encode(array("error" => $lang["reg"]["email_error"])));
        die(json_encode(array("ok" => $lang["misc"]["ok"])));
		break;
	case "pass":
		 if (strlen($_POST["pass"]) < $plugin_conf["minpasslen"])
           	die(json_encode(array("error" => str_replace("%len",$plugin_conf["minpasslen"],$lang["reg"]["passminlen_error"]))));
         if (strlen($_POST["pass"]) > $plugin_conf["maxpasslen"])
           		die(json_encode(array("error" => str_replace("%len",$plugin_conf["maxpasslen"],$lang["reg"]["passmaxlen_error"]))));
         die(json_encode(array("ok" => $lang["misc"]["ok"])));
         break;
    case "code":
    	if (strlen($_POST["value"]) != 7)
    		die(json_encode(array("error" => $lang["reg"]["codelen_error"])));
    	die(json_encode(array("ok" => $lang["misc"]["ok"])));
}
?>