<?php
/*
 * 1.php
 * 
 * Copyright 2018 root <root@giuseppe-ThinkPad-T410>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>scelta del dato</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
</head>

<body>
		
<?php
    //richiamo template per la connessione al database
	include 'db.inc.php';
	$output = 'connessione al database stabilita';
    //include 'output.html.php';


    //seleziono il sensore di cui voglio avere informazioni
    //funzione che crea un elenco a discesa, argomenti sono nome dell'elenco e vettore con la lista
  
	echo $output
?>
	<form name="frmdropdown" method="post" action="1res.php">
	<strong> Select Designation : </strong>
	<select name="sensor_code"> 
	<option value=""> -----------ALL----------- </option>
		<?php
			//preparo la query per recuperare il numero dei sensori
			$sql1 = $pdo->prepare("SELECT DISTINCT sensor_id FROM temperature ORDER BY sensor_id ASC");
			// eseguo la query
			$sql1->execute();
	
			foreach ($sql1 as $row) {
			$id = $row["sensor_id"];
			echo $id;
			echo $row["sensor_id"];
			echo $row[0];
			echo "<option value = '$row[0]'> $row[0] </option>";
			}
		?>		
	</select>
	
	<input type="submit" name="find" value="find"/> 
    <br><br>
  
</form>
</body>

</html>
