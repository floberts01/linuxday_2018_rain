<?php
// Autor: Jens Leopold 
//
// Kontakt: info@jleopold.de
//
//
// P r o j e k t: Arduino-Aquarium-Temperatur-Überwachung
// -------------------------------------------------------
//
// PHP-Skript, welches von Arduino benutzt wird, um Werte in die mySQL-Datenbank einzutragen
//
// werden keine Daten per "?TEMP=......" übergeben, wird der aktuellste Wert aus der Datenbank angezeigt
//

//Datenbank-Verbindung herstellen
//--------------------------------
//richiamo template per la connessione al database
include 'db.inc.php';


// GET mit Prüfung (durch Aufruf von "http://aquarium.jleopold.de/arduino_push_data.php?TEMP=21.90&key=XXXXXXXXX")
//-----------------
if (isset($_GET['TEMP']))
{ 
//and (($_GET['key']) == "XXXXXXXXXX")) {	// Wenn 'TEMP' übergeben wurde und key stimmt...
	$temperatura = ($_GET['TEMP']);
	echo $temperatura;
	$sensor_id = ($_GET['ID']);
	echo $sensor_id;
	
//	$eintragen = mysql_query("INSERT INTO mySQL_TABELLENNAME (TEMP,DATE)	VALUES ($TEMP, NOW())");	// TEMP real übergeben, DATE = automatischer SQL-Befehl (NOW)
	$sql1 = $pdo->prepare("INSERT INTO temperature (value_temperature, sensor_id) VALUES ($temperatura, $sensor_id)");
//     eseguo la query
	$sql1->execute();
}

?>
