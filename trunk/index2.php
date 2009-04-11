<?php
	/*
			Het systeem:
			(1) ophalen van de bestanden tabel
			(2) neerzetten van de schermtabel
			(3) verwerken van invoer van gebruiker (de switch/case lus, maar dan anders)
			
			Systeem:
			Tabel:  set# sol# script_naam schaduw_naam week dag uur jaar pwd toelichting
			
			 
	*/
		
	// cosmetica aan de bovenkant en utilities
	include "kop.php";
	include "db_inc.php";
	
	// paar variabelen klaar zetten
	$script_set = 1;
	$antwoorden = array();
	$toelichtingen = array();
	$element = 0;
	$element2 = 0;
	
	// database verkeer
	// stap 1 en 2
	$mysql = db_contact();
	
	// stap 3
	$query = "SELECT * FROM uitwerkingen WHERE setnummer = '$script_set'";
	$query2 = "SELECT * FROM informatie WHERE nummer = '$script_set'";
	
	// stap 4 
	$resultaat = mysql_query($query, $mysql) or die ("De query kan niet uitgevoerd worden.");
	$resultaat2 = mysql_query($query2, $mysql) or die ("De 2e query kan niet uitgevoerd worden.");
	
	// array antwoorden vullen.
	//list($setnr, $solnr, $scr_naam, $scr_schaduw, $week, $dag, $uur, $jaar, $pwd, $toelichting)
	while(list($setnr, $solnr, $scr_naam, $scr_schaduw) = mysql_fetch_row($resultaat)) {
		$antwoord['set'] = $setnr;
		$antwoord['sol'] = $solnr;
		$antwoord['cnr'] = "s".$setnr."o".$solnr;
		$antwoord['scr'] = $scr_naam;
		$antwoord['sch'] = $scr_schaduw;
		/* 
		$antwoord['week'] = $week;
		$antwoord['dag'] = $dag;
		$antwoord['uur'] = $uur;
		$antwoord['jaar'] = $jaar;
		$antwoord['toe'] = $toelichting;
		*/
		$antwoorden[$element] = $antwoord;
		$element++;
	}
	
	list($nummer,$tekst,$titel) = mysql_fetch_row($resultaat2);
	$toelichting['nummer'] = $nummer;
	$toelichting['titel'] = $titel;
	$toelichting['toelichting'] = $tekst;
	
	
	print "<form action=\"".$_SERVER[PHP_SELF]."\" method=\"post\">";
	print "<table><tr><td width=\"30%\">";
	// binnenste table!!
	print "<table>";
  for ($i=0; $i<$element; $i++) {
		print "<tr><td><a href=\"".$antwoorden[$i]['scr']."\">".$antwoorden[$i]['sch']."</a></td>";
		print "<td><input type=\"submit\" value=\"Source\" name=\"".$antwoorden[$i]['cnr']."\"></td></tr>";
	}
	
	print "</table>"; // einde binnenste tabel
	
	//------------debug------------
  /*
	debug_print($_POST);
	debug_print($antwoorden);
	debug_print($toelichtingen); 
 	*/
	//-----------------------------
	print "<input type=\"hidden\" name=\"start\" value=\"ok\">";
	
	print "</td><td>";
	print "<h2>".$toelichting['titel']."</h2>";
	print "<p>".$toelichting['toelichting']."</p>";
	
	print "</td></tr>";
	print "</table>"; // einde buitenste tabel
	
	// hier de verwerkende lus onderin....

	print "</div>";
	print "<hr>";
	print "<table border=\"1\" width=\"100%\" cellpadding=\"25\"><tr><td bgcolor=\"#FFDC87\" >";

	include_once('../geshi.php');

	$geshi = new GeSHi($source, $language);

	if (isset($_POST['start'])) {
		$lijst = array_keys($_POST);
		$sleutel = $lijst[0];
		$bestand = "geenbestand.php";
		
		for ($i = 0; $i < $element; $i++) {
			if ($antwoorden[$i]['cnr']==$sleutel) {
				$bestand = $antwoorden[$i]['sch'];
			}
		}
		
    unset($_POST);
    $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
    $geshi->load_from_file("$bestand");
    echo "<h2>Sourcecode $bestand</h2>";
    echo $geshi->parse_code();

	}
	
	print "</td></tr></table>";
	print "<div align=\"center\">";
	mysql_close($mysql);
	include "voet.php";

?>
