<html>
<html>
<head>

<!-- <meta http-equiv = "refresh" content = "30" /> -->
     <meta charset="utf-8">
</head>
<body>
<ul>

		<h2>
		<table border="0" cellpadding=0" cellspacing="0">
			<tbody>
				<tr>
					<td 
					colspan="3" style="text-align: center"><img src="zeropoint_logo.png" alt="some_text" width="180" height="106">	
					 </td>
				</tr>
				<tr>
								
					<td>
						<img src="th.jpeg" alt="some_text" width="100" height="100">
					<td>
						<img src="th1.jpeg" alt="some_text" width="100" height="100"> 
					<td>
						<img src="th2.jpeg" alt="some_text" width="100" height="100">
				</tr>
				<tr>
					<td colspan="3" style="text-align: center"><img src="1.png" alt="some_text" width="300" height="80">	</td>
				</tr>
			</tbody>
		</table> 
		<h2>
<div id="header">		 
		<h2>RILEVAMENTI SENSORI</h2>
	</div>


<body>
<ul>



<?php
//richiamo template per la connessione al database
include 'db.inc.php';
//$output = 'connessione al database stabilita';
//include 'output.html.php';


//seleziono il sensore di cui voglio avere informazioni
//funzione che crea un elenco a discesa, argomenti sono nome dell'elenco e vettore con la lista

function generateSelect($name = '', $options = array()) {
    $html = '<form action =' .htmlentities($_SERVER['PHP_SELF']) .' method= "post" >';
    
    $html .='<p style="margin-left: 80px;"><label>select the sensor</label><br>';
    $html .='<p style="margin-left: 80px;">';
    $html .= '<select name="'.$name.'">';
    foreach ($options as $option => $value) {
        $html .= '<option value='.$value.'>'.$value.'</option>';
    }
    $html .= '</select>';
    $html .=  '<input type="submit" name="formSubmit" value="Submit" > </form>';

    return $html;
}

//preparo la query per recuperare il numero dei sensori
$sql1 = $pdo->prepare("SELECT DISTINCT sensor_id FROM temperature ORDER BY sensor_id ASC");
// eseguo la query
$sql1->execute();
//trasformo il risultato in vettore di valori
foreach ($sql1 as $row) {
    $sensors[] = $row["sensor_id"];
    }
//debug per vedere cosa contiene il vettore $sensor
//print_r ($sensors);
//richiamo la funzione per la generazione della lista sulla pagina
$html = generateSelect('sensorlist', $sensors);
//pubblico la lista
echo $html;

if(isset($_POST['sensorlist']) )
{
  
  //print_r ($_POST);
  $sensor = $_POST['sensorlist'];
  //echo $sensor;
  //preparo la query con un segnaposto :segnaposto che poi "bindo" o passo al momento dell'execute
  $sql1  = $pdo->prepare("SELECT COUNT(*) AS numrows FROM temperature WHERE sensor_id = :sensor_id ");
  
  //possibilità uno con bind unisco il segnaposto nell'sql al valore delle variabile 
  //$sql1->bindValue(':sensor_id', $sensor);
  //$sql1->execute();
  
  //oppure passo al volo il vettore di variabili, che nel caso è una sola
  $sql1->execute(array('sensor_id'=>$sensor));
//ora $sql1 è un resultset di cui faccio il fetch e assegno a row_cnt il campo numrows
$row_cnt  = $sql1->fetch()['numrows'];
//echo $row_cnt."\n";

// con questo sistema posso rifare le query in modo da avere i dati di ciascun sensore separatamente  
  
  
}
//echo $sensor;



// con PDO la riga $result = $mysqli->query($sql); diviene
//$result = $pdo->query($sql);
//con PDO la riga $row_cnt = $result->num_rows; non pare fattibile, sapere quante righe mi sono state restituite è un casino
//$row_cnt = $result->rowCount; darebbe il numero di righe maneggiate ma solo per operazioni di di delete, insert o update
//echo $row_cnt;
// carico in $row un data set
//$row = $result->fetch();
//$row cosa contiene ora ?
//echo print_r($row);
// per contare il numero di record pare si debba fare una query 
// per esempio preparo mysql alla esecuzione del query
//$sql1  = $pdo->prepare("SELECT COUNT(*) AS numrows FROM temperature");
// eseguo la query
//$sql1->execute();
//ora $sql1 è un resultset di cui faccio il fetch e assegno a row_cnt il campo numrows
//$row_cnt  = $sql1->fetch()['numrows'];
//echo $row_cnt;




// query per determinare il valore massimo delle temperature registrate
//$result_max = $pdo->query('SELECT MAX(value_temperature) FROM temperature');
//di default fetch()=fetch_both() che restituisce un array indicizzato sia per indice che per nome
//in questo caso è un vettore con un solo risultato posto alla posizione 0, non so che nome abbia essendo il risultato di una query con MAX(..)
// se query fosse "MAX(...) as ValoreMassimo" il valore lo ritrovo come $result_max->fetch()['ValoreMassimo']
//$result_max1 = $pdo->query('SELECT MAX(value_temperature) as ValoreMassimo FROM temperature'); 
//$max_temperature1 = $result_max1->fetch()['ValoreMassimo'];
//echo $max_temperature1;
$result_max = $pdo->prepare('SELECT MAX(value_temperature) FROM temperature WHERE sensor_id = :sensor_id ');
$result_max->execute(array('sensor_id'=>$sensor));
$max_temperature = $result_max->fetch()[0];
//echo $max_temperature;

$dati_sensori = $pdo->prepare('SELECT tipo_sensore, unita_misura FROM sensori WHERE sensor_id = :sensor_id ');
$dati_sensori->execute(array('sensor_id'=>$sensor));
$etichette = $dati_sensori->fetch(PDO::FETCH_ASSOC);
$etichetta_nome = $etichette['tipo_sensore'];
//echo $etichetta_nome;
$etichetta_simbolo = $etichette['unita_misura'];
//echo $etichetta_simbolo ."\n";
//echo $etichetta_nome . $etichetta_simbolo;





// query per determinare il valore minimo delle temperature registrate
//$result_min = $pdo->query('SELECT MIN(value_temperature) FROM temperature');
//$min_temperature = $result_min->fetch()[0];
//echo $min_temperature;
$result_min = $pdo->prepare('SELECT MIN(value_temperature) FROM temperature WHERE sensor_id = :sensor_id ');
$result_min ->execute(array('sensor_id'=>$sensor));
$min_temperature = $result_min->fetch()[0];
//echo $min_temperature ."\n";


// query per determinare il valore della media delle temperature registrate
//$result_avg = $pdo->query('SELECT ROUND(AVG(value_temperature),2) FROM temperature');
//$average_temperature = $result_avg->fetch()[0];
//echo $average_temperature;
$result_avg = $pdo->prepare('SELECT ROUND(AVG(value_temperature),2) FROM temperature WHERE sensor_id = :sensor_id');
$result_avg->execute(array('sensor_id'=>$sensor));
$average_temperature = $result_avg->fetch()[0];
//echo $average_temperature ."\n";


// query per determinare l'ultima lettura delle temperature registrate
//$result_last = $pdo->prepare('SELECT date_temperature, value_temperature FROM temperature ORDER BY id_temperature DESC LIMIT 1');
//$result_last->execute(array('sensor_id'=>$sensor));
//$last_data = $result_last->fetch(PDO::FETCH_ASSOC);
//$last_date_temperature = $last_data['date_temperature'];
//$last_value_temperature = $last_data['value_temperature'];
//echo $last_date_temperature ."\n";
//echo $last_value_temperature ."\n";



$result_last = $pdo->prepare('SELECT date_temperature, value_temperature FROM temperature WHERE sensor_id = :sensor_id ORDER BY id_temperature DESC LIMIT 1');
$result_last ->execute(array('sensor_id'=>$sensor));
$last_data = $result_last->fetch(PDO::FETCH_ASSOC);
$last_date_temperature = $last_data['date_temperature'];
$last_value_temperature = $last_data['value_temperature'];
//echo $last_date_temperature ."\n";
//echo $last_value_temperature ."\n";
//data ultima lettura in formato UNIX
$ultimalettura = strtotime($last_date_temperature)*1000;


//voglio scrivere nella tabella html la data dell'ultima lettura, 
//in particolare provo vari metodi per restituire formattato in modo diverso il campo data letto da mysql (nel suo formato, non unix)
//strtotime($stringa) tenta di convertire una data in formato stringa in una data in formato unix
//date(stringaesempio, dataunix) converte una data unix in una stringa data con un formato definito in stringaesempio
//$pichio = date('F d, Y h:i:s A', strtotime($last_date_temperature));
//echo $pichio;

//alternativamente creo un array associativo con i valori della data dell'ultima lettura del sensore
//date_parse(stringa_data) crea un vettore associativo dei componenti della data, anno, mese, giorno etc...
$last_date_array_temperature= date_parse($last_date_temperature);
//queste istruzioni mi servono per vedere a video i contenuti del vettore
//print_r($last_date_array_temperature= date_parse($last_date_temperature));
//ora posso prendere i singoli componenti del vettore ('aaaa', 'mm', etc...) nell'esempio l'ora [hour]
//print_r($last_hour_temperature=$last_date_array_temperature['hour']);

//per ultimo conoscendo la struttura fissa del campo data fornito da mysql (che viene letto come stringa) estraggo le sotto stringhe per ottenere  "aaaa/mm/gg" e "ora:min:sec"
//substr ( string $string , int $start [, int $length ] )
//data di sql = "aaaa-mm-gg hh:mm:ss", 10 caratteri da posizione 0 leggo "aaaa-mm-gg" e da 11 
// 8 caratteri da posizione 12 leggo "hh:mm:ss"
$stringa_anno = substr ($last_date_temperature , 0 , 10 );
//echo $stringa_anno;
$stringa_orario = substr ($last_date_temperature , 11 , 8 );
//echo $stringa_orario;

//echo $last_date_temperature;
//echo $last_value_temperature;
/*
*/



//richiamo template per la creazione della pagina con i risultati e l'intestazione di tabella dei valori
include 'tabella_riassuntiva.html.php';

//inserisco il grafico delle temperature
// tentativo di far rigenerare l'immagine inserendo la funzione now() che dovrebbe indurre in browser a ricaricare i dati
//echo "<img src='grafico_temperature.php'?dummy=\'.now(). >";
//echo "<img src='grafico_temperature.php' class='img_bordata'/><p></p>";









$sql = 'SELECT (id_temperature) AS id_temperature, (date_temperature) AS date_temperature, value_temperature 
    FROM temperature';
// con PDO la riga $result = $mysqli->query($sql); diviene
//$result = $pdo->query($sql);
//con PDO la riga $row_cnt = $result->num_rows; non pare fattibile, sapere quante righe mi sono state restituite è un casino
//$row_cnt = $result->rowCount; darebbe il numero di righe maneggiate ma solo per operazioni di di delete, insert o update
//echo $row_cnt;
// carico in $row un data set
//$row = $result->fetch();
//$row cosa contiene ora ?
//echo print_r($row);
// per contare il numero di record pare si debba fare una query 
// per esempio preparo mysql alla esecuzione del query
$sql1  = $pdo->prepare("SELECT COUNT(*) AS numrows FROM temperature");
// eseguo la query
$sql1->execute();
//ora $sql1 è un resultset di cui faccio il fetch e assegno a row_cnt il campo numrows
$row_cnt  = $sql1->fetch()['numrows'];
//$row_cnt;



// inserisco l'intestazione della tabella per i dati estratti dal database richiamando una formattazione salvata in file esterno
//include 'tabella_rilevamenti.html.php';
//ciclo la lettura dei dati registrati per inserirli nella tabella 

//  while ($row=$result->fetch()) {
//    $id = $row["id_temperature"];
//    $time = $row["date_temperature"];
//    $value_temperature = $row["value_temperature"];
//    include 'popola_tabella.html.php';
//    }

// ciclo per ogni result set 
/*foreach ($pdo->query($sql) as $row) {
    $id = $row["id_temperature"];
    $time = $row["date_temperature"];
    $value_temperature = $row["value_temperature"];
    include 'popola_tabella.html.php';
    }
*/ 
//alla fine del ciclo scrivo il tag di chiusura della tabella
//echo "</table>";




//prova di creazione del vettore dati per flot jquey

$sql2 = 'SELECT (id_temperature) AS id_temperature, UNIX_TIMESTAMP(date_temperature) AS date_temperature, value_temperature 
    FROM temperature WHERE sensor_id = :sensor_id';
$sql2 = $pdo->prepare($sql2);
$sql2->execute((array('sensor_id'=>$sensor)));

/*
include 'tabella_rilevamenti.html.php';
foreach ($sql2 as $row) {
    $id = $row["id_temperature"];
    $time = $row["date_temperature"];
    $value_temperature = $row["value_temperature"];
    include 'popola_tabella.html.php';
    }
echo "</table>";
*/



// formattazione del vettore dei risultati $return per la successiva lettura da flot
// il vettore è così formattato
// [[xdata,ydata],-------[xdata,ydata]]
$return = "[";
foreach ($sql2 as $row) {
    //$id = $row["id_temperature"] non usato;
    //$timing = strtotime($row["date_temperature"]); //trasforma data se in formato mysql
    $timing = $row["date_temperature"]; // con la precedente estrazione già in formato unix
    //$dt = ($row['timing']+36000)*1000; --ori diventa
    $dt = $timing*1000; //dt dovrebbero essere millisecondi da January 1 1970 00:00:00 UTC 
    //echo $dt;    
        
    $value_temperature = $row["value_temperature"];
    //$te = $row['temp']  --originale diventa;
    $te = $row["value_temperature"];
    //$te = (($te+252-500) / 10); // easier to do adjustments here
    //if($te>$result_max) $result_max=$te; // so the graph doesnt run along the top
    //if($te<$result_min) $result_min=$te; // or bottom of the axis
    $return = $return ."[$dt, $te], "; //creato vettore di coppie time/value
          
    }
    $return = trim($return, " ,");
    $return = $return ."]";
   //oppure nello script java converto al volo l'array in formato json
    //var json = <?php echo json_encode($return); >;
    //in teoria java dovrebe leggerlo al volo senza bisogno di convertire json in array   
     
  //print $return;
 
  //foreach ($return as $string){
  //print_r($string);
  //}
  
  




   $temp_min = $result_min;
   
   $temp_max = $result_max;
   


include 'flot_example_time.html.php';

?>



