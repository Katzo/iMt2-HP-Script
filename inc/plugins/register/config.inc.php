<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a plugin called "register"
 * guess what it does.
 */
$plugin_conf=array(
	"enabled" => true, // Enable Registration
	"verifyemail" => false, //Enable Email Verification (You might run into trouble here if your mail server is blocked for some reason)
	"multiemail" => true, // Multiple accounts per email
	"minpasslen" => 6,
	"maxpasslen" => 16,
	"minuserlen" => 4,
	"maxuserlen" => 16,
	"minsecqlen" => 6,
	"maxsecqlen" => 50,
	"minsecalen" => 4,
	"maxsecalen" => 50,
	"itemshop_boni" => array(
		"gold_expire" => 7,
		"silver_expire" => 7,
		"safebox_expire" => 7,
		"autoloot_expire" => 7,
		"fish_mind_expire" => 7,
		"money_drop_rate_expire" => 7,
	),
	"captcha" => false, // Enable captcha - its probably not necessary though unless your have problems with spammers
	/*
	 * If you want to use the captcha provide an array:
	 * "captcha" => array(
	 * 	"public_key" => "PUBLIC KEY HERE",
	 * 	"private_key" => "PRIVATE KEY HERE",
	 * )
	 * 
	 * i am using recaptcha for captcha verification - its a free service
	 * sign up and get a key here: http://www.google.com/recaptcha
	 */
);
 ?>