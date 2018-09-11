<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    
    <title> provadi elaborazione tabelle</title>


<!--impostazioni di stile per gli elementi della pagina -->

<style type="text/css">

.img_bordata{
border: 1px solid #4F6A98;
}

table {
margin-left: auto;
margin-right: auto;
font-family: Arial, Helvetica, sans-serif;
border: solid 1px #000000;
spacing: 60px;
}
th {
background-color:green;
color:white;
}



td {
border: solid 1px #000000;
padding: 1px;
}

.right{
text-align:right;
}

p {
font-family: Arial, Helvetica, sans-serif;
text-align: justify; /* commento per allineamento giustificato */
color: #ff0000; /* commento per colore rosso */
}

</style>



<!-- inserisco la prima tabella con i riassunti delle letture-->

<TABLE>

<tr>
<td>numero rilevamenti:  </td>
<td class="right"><?php echo $row_cnt;?></td>
</tr>
<tr>
<td><?php echo $etichetta_nome;?> massima:  </td>
<td class="right"><?php echo $max_temperature ."\n" .$etichetta_simbolo;?></td>
</tr>
<tr>
<td><?php echo $etichetta_nome;?> minima:  </td>
<td class="right"><?php echo $min_temperature ."\n".$etichetta_simbolo;?></td>
</tr>
<tr>
<td><?php echo $etichetta_nome;?> media:  </td>
<td class="right"><?php echo $average_temperature ."\n" .$etichetta_simbolo;?></td>
</tr>

<tr>
<td>ULTIMA LETTURA:  </td>
<td class="right"><?php echo $last_value_temperature ."\n" .$etichetta_simbolo;?>
      </br> alle ore <?php echo $last_date_array_temperature['hour'].":".$last_date_array_temperature['minute'].":".$last_date_array_temperature['second'] ?>
      </br>del <?php echo $last_date_array_temperature['year']."-".$last_date_array_temperature['month']."-".$last_date_array_temperature['day'] ?></br>
</td>
</tr>

<tr>
<td>oppure ULTIMA LETTURA:  </td>
<td class="right"><?php echo $last_value_temperature ."\n" .$etichetta_simbolo;?>
      </br> alle ore <?php echo $stringa_orario ?>
      </br>del <?php echo $stringa_anno ?></br>
</td>
</tr>






