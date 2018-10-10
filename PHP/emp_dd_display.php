 <html>
	<?php
     include 'db.inc.php';  // including configuration file;
	?>

<head>
	<link href="examples.css" rel="stylesheet" type="text/css">
</head>

 <body>
      
     <form name="frmdropdown" method="post" action="emp_dd_display.php">
     <center>
            <h2 align="center">Sensor Raw Data</h2>
            <strong> Select Sensor code : </strong> 
             <select name="Sensor_code"> 
               <option value=""> select a sensor </option> 
				<?php
					$dd_res = $pdo->prepare("SELECT DISTINCT sensor_id FROM temperature ORDER BY sensor_id ASC");
					$dd_res->execute();
					foreach ($dd_res as $r)
					{ 
						echo "<option value='$r[0]'> $r[0] </option>";
					}
				?>
             </select>
     <input type="submit" name="find" value="find"/> 
     <br><br>
 
 <?php
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//echo print_r($_POST);
		$des=$_POST["Sensor_code"]; 
		if($des=="")  // if no selector has been choosen
		{ 
			echo "please select a sensor";
		}
        else
         { 
 	
 			$res = $pdo->prepare("Select * from temperature where sensor_id=".$des);
			$res->execute();
         
   		   
			echo "<table border='1'>";
			echo "<tr><td style='text-align: center'; colspan='3'> sensor number $des </td></tr>";
			echo "<tr align='center'>";
			echo "<th>id</th>      <th>date_measurement</th>     <th>value_measured</th>";
			echo "</tr>";
			
 			
			foreach($res as $r)
			{
				echo "<tr>";
				echo "<td >$r[0]</td>";
				echo "<td >$r[1]";
				echo "<td style='text-align: right;'> $r[2]</td>";
				echo "</tr>";
			}
		}
    }
?>
  </table>
 </center>
</form>
</body>
</html>
