<?php

//richiamo template per la connessione al database
include 'db.inc.php';


// GET  chiamando "http://Alex.com/arduino_push_data.php?TEMP=21.90&ID=XXXXXXXXX&key=YYYYY")
// poi semplificata per eliminare la chiave che sarebbe servita come controllo per accettare la comunicazione
//-----------------
if (isset($_GET['TEMP']))
{ 
//and (($_GET['key']) == "XXXXXXXXXX")) {	// se la chiave inviata corrisponde alla chiave "XXXXXXXXXX"
	$temperatura = ($_GET['TEMP']);
	echo $temperatura;
	$sensor_id = ($_GET['ID']);
	echo $sensor_id;

//	preparo la query	
	$sql1 = $pdo->prepare("INSERT INTO temperature (value_temperature, sensor_id) VALUES ($temperatura, $sensor_id)");

//     eseguo la query
	$sql1->execute();
}

?>
