<?php


//$connection = mysql_connect("localhost","temp_user","temp_user_psw");
//if (mysqli_connect_errno())
//  {
//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
//  }
//mysql_select_db("temperature", $connection);

$connection = mysql_connect("localhost","temp_user","temp_user_psw") or die ('Impossibile connettersi al server: ' . mysql_error());
mysql_select_db("temperature", $connection) or die('Impossibile selezionare il database: ' . mysql_error());

$seconds = 2;
echo $seconds. "\n</br>";  

 for ($r=1; $r<=50; $r++) {
	for ($c=1; $c<=3; $c++) {
		$sensorID=(100 * $c + 1);
		$temperatura =rand(2000,3000)/100;
		echo $temperatura. "---------" . $sensorID;
		mysql_query("INSERT INTO temperature (value_temperature, sensor_id) VALUES ($temperatura, $sensorID)");
		echo date('h:i:s') . "\n</br>";
		sleep ( $seconds );
	}
  
  }



mysql_close($connection);
 
?>

