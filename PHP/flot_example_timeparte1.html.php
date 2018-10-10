
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Flot Examples: Time Axes</title>
	<link href="examples.css" rel="stylesheet" type="text/css">
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="../js/flot/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.time.js"></script>
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
