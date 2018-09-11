<?php
DEFINE ("Host", "localhost");
DEFINE ("User", "temp_user");
DEFINE ("Password", "temp_user_psw");
DEFINE ("Database", "temperature");

// connect to MySQL
$connection = mysql_connect("localhost","temp_user","temp_user_psw");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysql_select_db("temperature", $connection);



//if(ISSET($_GET['t']) && (is_numeric($_GET['t'])) && $_SERVER['REMOTE_ADDR']=='10.1.1.177'){
// ISSET — Determine if a variable is set and is not NULL  
if(ISSET($_GET['t']))
{  
  // message from the Arduino
  $temperatura = $_GET['t'];
  echo $temperatura . "\n</br>";
  $sensor_id = $_GET['id'];
  echo $sensor_id . "\n</br>";
  
  // echo $temperatura. "---------";
  mysql_query("INSERT INTO temperature (value_temperature, sensor_id) VALUES ($temperatura, $sensor_id)");
  
  echo date('h:i:s') . "\n</br>";
  
  mysql_close($connection);
  
}
?>
