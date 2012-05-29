<?php
if (!isset($_POST["what"]) || empty($_POST["what"])) exit;
$plugin_conf=$ConfigProvider->get("plugin_register");
switch ($_POST["what"]){
	case "user":
		if (strlen($_POST["value"]) < $plugin_conf->get("minuserlen"))
       		die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("minuserlen"),$lang->get("register_userminlen_error")))));
        if (strlen($_POST["value"]) > $plugin_conf->get("maxuserlen"))
           	die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("maxuserlen"),$lang->get("register_usermaxlen_error")))));
        $q = mysql_query('SELECT id FROM '.$db->gamedb["account"].'.account WHERE login="'.mysql_real_escape_string($_POST["value"]).'" LIMIT 1',$db->game);	
		if (mysql_num_rows($q))
			die(json_encode(array("error" => $lang->get("register_account_exists"))));
		die(json_encode(array("ok" => $lang->get("ok"))));
		break;
	case "email":
		if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})^", $_POST["value"])) 
           	die(json_encode(array("error" => $lang->get("register_email_error"))));
        die(json_encode(array("ok" => $lang->get("ok"))));
		break;
	case "pass":
		 if (strlen($_POST["value"]) < $plugin_conf->get("minpasslen"))
           	die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("minpasslen"),$lang->get("register_passminlen_error")))));
         if (strlen($_POST["value"]) > $plugin_conf->get("maxpasslen"))
           		die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("maxpasslen"),$lang->get("register_passmaxlen_error")))));
         die(json_encode(array("ok" => $lang->get("ok"))));
         break;
	case "security_question":
		 if (strlen($_POST["value"]) < $plugin_conf->get("minsecqlen"))
           	die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("minsecqlen"),$lang->get("register_secqminlen_error")))));
         if (strlen($_POST["value"]) > $plugin_conf->get("maxsecqlen"))
           		die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("maxsecqlen"),$lang->get("register_secqmaxlen_error")))));
         die(json_encode(array("ok" => $lang->get("ok"))));
         break;
	case "security_answer":
		 if (strlen($_POST["value"]) < $plugin_conf->get("minsecalen"))
           	die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("minsecalen"),$lang->get("register_secaminlen_error")))));
         if (strlen($_POST["value"]) > $plugin_conf->get("maxsecalen"))
           		die(json_encode(array("error" => str_replace("%len",$plugin_conf->get("maxsecalen"),$lang->get("register_secamaxlen_error")))));
         die(json_encode(array("ok" => $lang->get("ok"))));
         break;
    case "code":
    	if (strlen($_POST["value"]) != 7)
    		die(json_encode(array("error" => $lang->get("register_codelen_error"))));
    	die(json_encode(array("ok" => $lang->get("ok"))));
}
?>