<?php

$db_server = "localhost";
$db_user = "dsf";
$db_pass = "feike9";
$db_name = "uitwerkingen";

function db_contact() {
	
	global $db_server, $db_user,  $db_pass, $db_name;
	
	// maak contact met de sql server
	$db = mysql_connect($db_server,$db_user,$db_pass) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
	
	// selecteer de juiste database
	mysql_select_db($db_name,$db) or die("Fout: Het openen van de database is mislukt!");
	
	// geef een handle naar de database terug
	return $db;	
}

// kleurwisselfunctie voor tabelrijen.
function kleurwissel($teller) {
	$kc = $teller % 2;
	if ($kc == 0) {
		$kleur = "#CCCCCC";
	} else {
		$kleur = "#FFFF55";
	}
	return $kleur;
}

// debug printen van arrays.
function debug_print($lijst) {
	print "<pre>";
	print_r($lijst);
	print "</pre>";
}


?>