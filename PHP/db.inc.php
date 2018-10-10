<?php

DEFINE ("Host", "localhost");
DEFINE ("User", "temp_user");
DEFINE ("Password", "temp_user_psw");
DEFINE ("Database", "temperature");

//$connection = mysql_connect(Host,User,Password) or die ('Impossibile connettersi al server: ' . mysql_error());
//mysql_select_db("temperature", $connection) or die('Impossibile selezionare il database: ' . mysql_error());


// $sql = 'SELECT * FROM temperature';
// mysql timestamp salva i dati come (aaaa-mm-gg hh:mm:ss) mentre PHP in formato unix (intero del tipo 1376410932)
// converto data di sql in formato unix che usa php per poi usare jpgraph con i grafici per le date


//questa versione è usando PDO
//$mysqli = new mysqli(Host,User,Password,Database);
//if ($mysqli->connect_errno) {
//    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
//}

try{
   $stringa = 'mysql:host=' .Host.';dbname='.Database;
//echo $stringa;

// non ho trovato modo di inserire le costanti definite nella stringa per inizializzare PDOException
// perciò ho costruito prima la stringa e poi passata come variabile
   $pdo = new PDO($stringa, User, Password);
 
// $pdo = new PDO('mysql:host=localhost;dbname=temperature', User, Password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
 
}

catch (PDOException $e)
{
$output =' impossibile connetersi al server Mysql';
include 'output.html.php';
exit();
}
