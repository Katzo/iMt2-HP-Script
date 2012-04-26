<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 */
// Lang
$lang = array(
	"time" => array(
		"s" => "Sekunden",
		"S" => "Sekunde",
		"m" => "Minuten",
		"M" => "Minute",
		"h" => "Stunden",
		"H" => "Stunde",
		"a" => "vor",
		"af" => "ein paar",
		"format" => "%ago %value %time",
		"tformat" => "d.m.y H:i",
	),
	"misc" => array(
		"notfound" => "404 - Nicht Gefunden",
		"ok" => "&radic;",
		"fillout" => "Bitte f&uuml;lle alle Felder aus",
		"coin" => "Coin",
		"charname" => "Charakter",
		"coins" => "Coins",
		"noacc" => "Kein Account mit diesem Usernamen oder Passwort gefunden ",
		"pass" => "Passwort",
		"oldpass" => "Altes Passwort",
		"repeat" => "Wiederholen",
		"user" => "Username",
		"level" => "Level",
		"email" => "Email",
		"code" => "L&ouml;schcode",
		"login" => "Login",
		"logout" => "Logout",
		"register" => "Registrieren",
		"forgot" => "Passwort vergessen",
		"accsupport" => "Probleme beim Einloggen?",
		"hello" => "Hallo <b>%username</b>,",
		"youcoin" => "Du hast <b><span class='coins'>%coins</span></b> %coinname!", // Class coins is used for auto updating coins
		"donate" => "Spenden",
		"char" => "Deine Charaktere",
		"itemshop" => "Itemshop",
		"settings" => "Einstellungen",
		"ranking" => "Rangliste",
		"submit" => "Absenden",
		"allclasses" => "Gesammt",
		"warrior" => "Krieger",
		"assassin" => "Ninja",
		"sura" => "Sura",
		"shaman" => "Schamanen",
		"classrank" => "Klassen-#",
		"class" => "Klasse",
		"search" => "Suchen",
		"download" => "Download",
		"systemrequirements" => "Systemvoraussetzungen",
		"needlogin" => "Bitte logge dich ein.",
		"servererrorcontact" => "Ein schwerwiegender Fehler ist aufgetreten!<br/>Bitte versuche es nocheinmal.<br/>Falls das Problem weiterhin besteht, kontaktiere bitte einen Teamler!",
		"captcha" => "Captcha",
		"vote4coins" => "Vote 4 Coins",
		"vote" => "Vote",
		"banned" => "Du bist gebannt",
		"next" => "Vor",
		"back" => "Zur&uuml;ck",
	),
	"reg" => array(
		"captcha_error" => "Den Captcha, den du eingegeben hast, stimmt nicht.",
		"register_closed" => "Die Registration ist im Moment leider geschlossen.<br/>Bitte versuche es sp&auml;ter nocheinmal, da dies h&ouml;chstwahrscheinlich nur eine tempor&auml;re Ma&szlig;nahme ist.",
		"register_loggedin" => 'Du hast schon einen Account!<br/>Wenn das nicht dein Account ist logge dich bitte aus: <a href="'.$urlmap["logout"].'">Logout</a>',
		"passrepeat_error" => "Das Passwort und die Wiederholung stimmen nicht &uuml;berein.",
		"account_exists" => "Ein Account mit diesem Namen existiert bereits.",
		"codelen_error" => "Dein L&ouml;schcode muss 7 Zeichen lang sein.",
		"email_error" => "Deine Email scheint nicht richtig zu sein",
		"multiacc_error" => "Du hast bereits einen Account auf dieser Email",
		"userminlen_error" => "Dein Username muss mindestens %len Zeichen lang sein",
		"usermaxlen_error" => "Dein Username darf maximal %len Zeichen lang sein",
		"passminlen_error" => "Dein Passwort muss mindestens %len Zeichen lang sein",
		"passmaxlen_error" => "Dein Passwort darf maximal %len Zeichen lang sein",
		"emailsubject" => "Deine Registration auf ".$config["settings"]["name"],
		"emailbody" => "Hallo %username,\nUm deine Registrierung auf ".$config["settings"]["name"]." zu vervollst�ndigen, musst du nur auf diesen Link klicken:\n%url\n\nDein ".$config["settings"]["name"]." Team",
		"success_emailverify" => "Deine Registration war erfolgreich!<br/>Wir haben dir eine Email geschickt um deine Email Adresse zu best�tigen<br/>Bitte klicke den Link in der Email um deinen Account zu best�tigen",
		"success" => "Deine Registration war erfolgreich!",
		"verify_error" => "Verzifizierung fehlgeschlagen!<br/>Bitte kopiere den Link wenn du Probleme hast!",
		"verify_success" => "Du hast deinen Account erfolgreich verifiziert!<br/>Du kannst nun mit ihm spielen!",
	),
	"sysreq" => array(
		"os" => "OS",
		"cpu" => "CPU",
		"mem" => "RAM",
		"hdd" => "HDD",
		"graphics" => "Grafikkarte",
		"sound" => "Soundkarte",
	),
	"settings" => array(
		"change_password" => "Passwort &auml;ndern",
		"change_password_text" => "Hier kannst du dein Passwort &auml;ndern.<br/>Du musst nur dein altes Passwort eingeben, um zu best&auml;tigen, dass dies dein Account ist.<br/>",
		"change_code" => "L&ouml;schcode &auml;ndern",
		"change_code_text" => "Hier kannst du deinen L&ouml;schcode &auml;ndern<br/>Du musst nur dein Passwort eingeben, um zu best&auml;tigen, dass dies dein Account ist<br/>",
		"reset_safebox" => "Lagerpasswort zur&uuml;cksetzen",
		"reset_safebox_text" => "Hier kannst du dein Lagerpasswort zur&uuml;cksetzen<br/>Falls du dies tust, wird es zu <b>0000000</b> ge&auml;ndert<br/>Du musst nur dein Passwort eingeben, um zu best&auml;tigen, dass dies dein Account ist<br/>",
		"change_email" => "Email &auml;ndern",
		"change_email_text" => "hier kannst du deine aktuelle Email &auml;ndern<br/>Du musst nur dein Passwort eingeben, um zu best&auml;tigen, dass dies dein Account ist<br/>",
		"pass_error" => "Das Passwort stimmt nicht �berein!",
		"pass_changed" => "Dein Passwort wurde erfolgreich ge&auml;ndert!",
		"code_changed" => "Dein L&ouml;schcode wurde erfolgreich ge&auml;ndert!",
		"safebox_reseted" => "Dein Lagerpasswort wurde erfolgreich zur&uuml;ckgesetzt! (Es ist jetzt <b>0000000</b>)",
		"emailsubject" => "Email �nderung auf ".$config["settings"]["name"],
		"emailbody1" => "Hallo %username,\nUm deine Email �nderung auf ".$config["settings"]["name"]." zu best�tigen, musst du auf diesen Link klicken:\n".$config["settings"]["baseurl"].$urlmap["settings"]."&key1=%key\nDein ".$config["settings"]["name"]." Team",
		"emailbody2" => "Hallo %username,\nUm deine Email �nderung auf ".$config["settings"]["name"]." zu best�tigen, musst du auf diesen Link klicken:\n".$config["settings"]["baseurl"].$urlmap["settings"]."&key2=%key\nDein ".$config["settings"]["name"]." Team",
		"verifymailsent" => "Wir haben eine Email zu deiner neuen und alten Email Adresse gesendet.<br/>Bitte klicke beide Links in den Emails um deine Email zu &auml;ndern.",
		"email_changed" => "Deine Email wurde erfolgreich ge&auml;ndert!",
		"verify_otheremail" => "Diese Email wurde best&auml;tigt!<br/> Bitte klicke nun auf den Link in der anderen.",
	),
	"itemshop" => array(
		"buy" => "Kaufen",
		"buy_again" => "Nochmal Kaufen",
		"price" => "Preis",
		"cat" => "Kategorieren",
		"caterror" => "Ich konnte diese Kategorie leider nicht finden! Das tut mir leid! :(",
		"itemerror" => "Ich konnte dieses Item leider nicht finden!",
		"priceerror" => "Du hast nicht genug Coins um das zu kaufen!",
		"success" => "Das Item wurde erfolgreich gekauft! Es befindet sich in deinem Itemshoplager",
		"success" => "Das Item wurde erfolgreich gekauft!",
	),
	"donate_psc" => array(
		"code" => "Paysafecard Code",
		"coincalc" => "Coin Rechner",
		"notecalc" => "Bitte beachte, dass bei der Konvertierung von Coins zu Euro keine Coinboni mitberechnet werden.",
		"success" => "Deine Paysafecard ist g&uuml;ltig und wurde erfolgreich eingetragen!<br/> Warte nun, bis ein Teamler deine Paysafecard erneut kontrolliert und dir deine Coins gutschreibt!<br/>Dies sollte <b>maximal 24 Stunden</b> dauern.",
		"messages" => array(
	        'error_fields_blank' => 'Sie haben nicht alle Felder ausgef&uuml;llt.',
	        'error_code' => 'Bei deinem PIN-Code und/oder Passwort ist ein Fehler aufgetreten. Bitte &uuml;berpr&uuml;fe die korrekte Eingabe des PIN-Code oder Passwort.',
	        'error_code_pw' => 'Bei deinem PIN-Code und/oder Passwort ist ein Fehler aufgetreten. Bitte &uuml;berpr&uuml;fe die korrekte Eingabe des PIN-Code oder Passwort.',
	        'error_captcha' => 'Der eingegebene Text stimmt nicht mit dem angezeigten &Uuml;berein.',
	        'error_unknown' => 'Es ist ein unbekannter Fehler aufgetreten',
	        'error_online' => 'Es ist ein unbekannter Fehler aufgetreten. Bitte versuche es sp&auml;ter nocheinmal.',
	        'error_noteuro' => 'Die Paysafecard hat eine nicht akzeptierte W&auml;hrung',
	        'error_empty' => 'Die Paysafecard hat ein zu geringes Guthaben.',
	        'error_try' => 'Zu viele Fehlversuche'   
	    )
	),
	"vote" => array(
		"desc" => "Unterst&uuml;tze unseren Server durch voten.<br/>Als Dankesch&ouml;n bekommst du %coins Coins.<br/>Du kannst nur alle %time Stunden voten",
		"howto" => "Klicke den Voten-Button und vote auf der Topliste.<br/> Wenn du damit fertig bist, klicke bitte auf den Fertig-Button um deine Coins zu erhalten.du musst eventuell Pop-Ups f&uuml;r diese Seite erlauben.",
		"already" => "Du hast schon gevotet! Bitte versuche es in %time nocheinmal",
		"check" => "Pr�fen",
		"tryagain" => "Versuche es bitte erneut. Deine Session ist abgelaufen",
	)
);

?>