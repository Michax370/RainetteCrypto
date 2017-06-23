<?php
session_start ();
?>

<html>
<meta charset="UTF-8">
<link href="../bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link href="../css/mystyle.css" rel="stylesheet">
<link href="../css/style-xlarge.css" rel="stylesheet">
<link href="../css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/map.js"></script>
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdQDhz8AnkA1QEn5N0vaZ1aF8-U6DC8jA&callback=myMap"></script>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<h1>
		<center>Carte interactive des revendeurs
	
	</h1>
	<div id="googleMap" style="width: 100%; height: 600px;"></div>
	<div id="connectedAs" style="margin-top: -875px;">Connecté en tant que <?php echo $_SESSION['login'];?>
			</div>
</body>
</html>