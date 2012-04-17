<?php
$plugin_conf=array(
	"rate" => 15, // cash to coins
	"mincredit" => 1, // min. credit on psc to be able to use it (to prevent 0.01euro psc's from being used)
	"boni" => array( // Adds only once and only the biggest ammount
		10 => 50, 
		25 => 100,
		50 => 250,
		100 => 500,
	),
	"currency" => array( // Allowed currencies and conversion rates
						 // See http://www.paysafecard.com/exchange/exchange.php for up to date currencies and conversion rates
		"EUR" => 1,
		"CHF" => 1.17,
	)
);
?>