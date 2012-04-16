<?php
// Lang
$lang = array(
	"time" => array(
		"s" => "seconds",
		"S" => "second",
		"m" => "minutes",
		"M" => "minute",
		"h" => "hours",
		"H" => "hour",
		"a" => "ago",
		"af" => "a few",
		"format" => "%value %time %ago",
		"tformat" => "d.m.y H:i"
	),
	"misc" => array(
		"notfound" => "404 - Not Found",
		"ok" => "&radic;",
		"fillout" => "Please fill out all fields",
		"coin" => "Coin",
		"charname" => "Character",
		"coins" => "Coins",
		"noacc" => "No account with that password or username found",
		"pass" => "Password",
		"oldpass" => "Old password",
		"repeat" => "Repeat",
		"user" => "Username",
		"level" => "Level",
		"email" => "Email",
		"code" => "Code",
		"login" => "Login",
		"logout" => "Logout",
		"register" => "Register",
		"forgot" => "Forgot password",
		"accsupport" => "Trouble signing in?",
		"hello" => "Hello <b>%username</b>,",
		"youcoin" => "You have <b>%coins</b> %coinname!",
		"donate" => "Donate",
		"char" => "Your characters",
		"itemshop" => "Itemshop",
		"settings" => "Settings",
		"ranking" => "Ranking",
		"submit" => "Submit",
		"banned" => "Your account is banned",
		"allclasses" => "General",
		"warrior" => "Warrior",
		"assassin" => "Assassin",
		"sura" => "Sura",
		"shaman" => "Shaman",
		"classrank" => "Class-#",
		"class" => "Class",
		"search" => "Search",
		"download" => "Download",
		"systemrequirements" => "System requirements",
		"needlogin" => "Please login",
	),
	"reg" => array(
		"captcha_error" => "The captcha you entered is wrong.",
		"register_closed" => "The registration is currently closed<br/>Please check back later cause this is probably just temporary.",
		"register_loggedin" => 'You already have an account.<br/>If this is not your account please <a href="'.$urlmap["logout"].'">Logout</a>',
		"passrepeat_error" => "The password and the repeated one didnt match.",
		"account_exists" => "An account with this name already exists",
		"codelen_error" => "Your code has to be 7 characters long",
		"email_error" => "Your email doesnt seem to be valid",
		"multiacc_error" => "There is already an account on this email",
		"userminlen_error" => "Your username has to be at least %len characters long",
		"usermaxlen_error" => "Your username must be under %len characters long",
		"passminlen_error" => "Your password has to be at least %len characters long",
		"passmaxlen_error" => "Your password must be under %len characters long",
		"emailsubject" => "Your registration on ".$config["settings"]["name"],
		"emailbody" => "Hello %username,\nTo complete your registration on ".$config["settings"]["name"]." you just have to click this link:\n".$config["settings"]["baseurl"].$urlmap["register"]."&key=%key\nYour ".$config["settings"]["name"]." Team",
		"success_emailverify" => "Your Registration was sucessfull!<br/>An email was sent to verify your email adress is valid.<br/>Please click the link in the email to verify your account.",
		"success" => "Your Registration was sucessfull!",
		"verify_error" => "Verification failed!<br/>Please copy the link if you have trouble!",
		"verify_success" => "You just verified your account!<br/>You may use your account to play now",
	),
	"sysreq" => array(
		"os" => "OS",
		"cpu" => "CPU",
		"mem" => "Memory",
		"hdd" => "HDD",
		"graphics" => "Graphics Card",
		"sound" => "Sound Card",
	),
	"settings" => array(
		"change_password" => "Change Password",
		"change_password_text" => "You may change your password here.<br/>You just have to enter your old one to verify you own this account.<br/>",
		"change_code" => "Change Code",
		"change_code_text" => "You may change your character deletion code here<br/>You just have to enter your password to verify you own this account<br/>",
		"reset_safebox" => "Reset Safebox Password",
		"reset_safebox_text" => "You may reset your safebox password here.<br/>It will be changed to <b>0000000</b><br/>You just have to enter your password to verify you own this account<br/>",
		"change_email" => "Change email",
		"change_email_text" => "You may change your current email here.<br/>You just have to enter your password to verify you own this account<br/>",
		"pass_error" => "Your password didn't match!",
		"pass_changed" => "Your password was successfully changed!",
		"code_changed" => "Your code was successfully changed!",
		"safebox_reset" => "Your safebox password was successfully reset! (It's <b>0000000</b> now)",
		"emailsubject" => "Email change on ".$config["settings"]["name"],
		"emailbody1" => "Hello %username,\nTo complete the email change on ".$config["settings"]["name"]." you just have to click this link:\n".$config["settings"]["baseurl"].$urlmap["settings"]."&key1=%key\nYour ".$config["settings"]["name"]." Team",
		"emailbody2" => "Hello %username,\nTo complete the email change on ".$config["settings"]["name"]." you just have to click this link:\n".$config["settings"]["baseurl"].$urlmap["settings"]."&key2=%key\nYour ".$config["settings"]["name"]." Team",
		"verifymailsent" => "We sent an email to your new and your old email address.<br/>Please click the link in both of the emails to verify the change. Just ignore them if you don't want to anymore.",
		"email_changed" => "Your email was successfully changed!",
		"verify_otheremail" => "This email was verified! Please go to the other one and click the link in there to complete change your email",
	),
	"itemshop" => array(
		"buy" => "Buy",
		"price" => "Price",
		"caterror" => "I could not find the category you were looking for.<br/>Please try one of the ones above!",
		"itemerror" => "I could not find the item you tried to buy.",
		"priceerror" => "You dont have enough coins to buy this",
		"success" => "You successfully bought it! You can find it in the mall",
	)
);

?>