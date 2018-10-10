<?php
$DB_host     = 'localhost';
$DB_user     = 'temp_user';
//$DB_password = 'oeN1Lahbaing';
$DB_password = 'temp_user_psw';
$DB_name     = 'temperature';


#------------------------------------------------------------------
#	connessione all'host
#------------------------------------------------------------------

#include 'db.inc.php';
#$output = 'connessione al database stabilita';
#echo $output . "<br/>";

$link = mysql_connect($DB_host, $DB_user, $DB_password);
if (!$link) {
	die ('Non riesco a connettermi: ' . mysql_error());
}
echo "connection ok" ."<br/>";

/*
#------------------------------------------------------------------
#	comando di backup del database e struttura su file
#------------------------------------------------------------------
*/


# indicazione del percorso completo
#$filename= '/var/www/html/Temperature_V01/database_backup_'.date('G_a_m_d_y').'.sql';

# file creato nella directory dove agisce lo script
$filename= 'database_backup_'.date('G_a_m_d_y').'.sql';

echo $filename ."<br/>";;

echo 'mysqldump --user='. $DB_user. ' --password=' .$DB_password. ' --host='. $DB_host. ' '.$DB_name .' --single-transaction > '.$filename;
$result=exec('mysqldump --user='. $DB_user. ' --password=' .$DB_password. ' --host='. $DB_host. ' '.$DB_name .' --single-transaction > '.$filename,$output);

if($output==''){/* no output is good */}
else {/* we have something to log the output here*/}

/*
#------------------------------------------------------------------
#	chiudo la connessione con l'host
#------------------------------------------------------------------
*/

mysql_close($link);
echo "<br><br><h3>" . "connessione con l'host chiusa" . "</h3><br><br>";      
?>
