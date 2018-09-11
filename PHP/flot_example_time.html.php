<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Flot Examples: Time Axes</title>
	<link href="examples.css" rel="stylesheet" type="text/css">
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="../flot/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../flot/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="../flot/jquery.flot.time.js"></script>
	<script type="text/javascript">

	$(function() {


var d = <?php echo $return ; ?>;
var Tmin = <?php echo $min_temperature;?>;
var Tmax = <?php echo $max_temperature;?>;
var LastTime = <?php echo $ultimalettura;?>;


<!-- var d = [[-373597200000, 315.71], [-370918800000, 317.45], [-368326800000, 317.50]] --> 

		$.plot("#placeholder", [d], {
			xaxis: { mode: "time" }
		});

		$("#whole").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: { mode: "time" }
			});
		});

		$("#nineties").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					min: (new Date(1990, 0, 1)).getTime(),
					max: (new Date(2000, 0, 1)).getTime()
				}
			});
		});
		
		$("#lastfiveminutes").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					min: Date.now()-300000,
					max: Date.now()
				}
			});
		});
		
		$("#lastfiveminutesread").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					min: LastTime-300000,
					max: LastTime
				}
			});
		});


		$("#latenineties").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					minTickSize: [1, "year"],
					min: (new Date(1996, 0, 1)).getTime(),
					max: (new Date(2000, 0, 1)).getTime()
				}
			});
		});

		$("#ninetyninequarters").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					minTickSize: [1, "quarter"],
					min: (new Date(1999, 0, 1)).getTime(),
					max: (new Date(2000, 0, 1)).getTime()
				}
			});
		});

		$("#ninetynine").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					minTickSize: [1, "month"],
					min: (new Date(1999, 0, 1)).getTime(),
					max: (new Date(2000, 0, 1)).getTime()
				}
			});
		});

		$("#lastweekninetynine").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					minTickSize: [1, "day"],
					min: (new Date(1999, 11, 25)).getTime(),
					max: (new Date(2000, 0, 1)).getTime(),
					timeformat: "%a"
				}
			});
		});

		$("#lastdayninetynine").click(function () {
			$.plot("#placeholder", [d], {
				xaxis: {
					mode: "time",
					minTickSize: [1, "hour"],
					min: (new Date(1999, 11, 31)).getTime(),
					max: (new Date(2000, 0, 1)).getTime(),
					twelveHourClock: true
				}
			});
		});

		$("#scala_temperature_fissa").click(function () {
			$.plot("#placeholder", [d], {
				yaxis: {
					min: -20,
					max: 40
				},
				xaxis: { mode: "time" }
			});
		});
		
 		$("#scala_temperature_auto").click(function () {
 			$.plot("#placeholder", [d], {
 				yaxis: {
 					min: Tmin*.9,
 					max: Tmax*1.1
 				},
 				xaxis: { mode: "time" }
 			});
 		}); 








		// Add the Flot version string to the footer

		$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
	});

	</script>
</head>
<body>

<!--	<div id="header">
		<h2>TEMPERATURE</h2>
	</div>
-->
	<div id="content">

		<div class="demo-container">
			<div id="placeholder" class="demo-placeholder"></div>
		</div>

		<p>Rilevamento temperature da sonde esterne<sub></sub> </p>
<!--
		<p>If you tell Flot that an axis represents time, the data will be interpreted as timestamps and the ticks adjusted and formatted accordingly.</p>
-->
		<p>Zoom to: <button id="whole">Periodo intero</button>
		<button id="lastfiveminutes">ultimi 5 minuti</button>
		<button id= "lastfiveminutesread">ultimi 5 minuti letti</button>
<!--		<button id="nineties">1990-2000</button>
		<button id="latenineties">1996-2000</button></p>
		
		
		<button id="lastfitftyminutes">ultimi 15 minuti</button></p>

		<p>Zoom to: <button id="ninetyninequarters">1999 per quadrimestri</button>
		<button id="ninetynine">1999 per mese</button>
		<button id="lastweekninetynine">ultima settimana del 1999</button>
		<button id="lastdayninetynine">Dec. 31, 1999</button></p>
-->
		<p>Zoom to: <button id="scala_temperature_fissa">scala temperature fissa -20 -- +40</button>
		<button id="scala_temperature_auto"> scala_temperature_auto</button>
		
<!--
		<p>il tempo deve essere specificato come Javascript timestamps, come millisecondi dal 01 gennaio 1970 00:00. E' simile al timestamp di UNIX ma in millisecondi invece di secondi (ricordati di moltiplicare per 1000!).</p>

		<p>un'altra attenzione, i timestamps sono interpretati come UTC e così mostrati. Puoi impostare la variabile "timezone" del browser per mostrare i timestamps nella timezone dell'utente oppure puoi specificarne una specifica usando timezoneJS, puoi specificare una time zone.</p>

	</div>
-->
	<div id="footer">
		LUGVicenza 2014 - Ing. A. Cecchetto
	</div>

</body>
</html>
