<?php
session_start ();
?>

<html>
<head>
<meta charset="UTF-8">
<link href="../bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link href="../css/mystyle.css" rel="stylesheet">
<link href="../css/style-xlarge.css" rel="stylesheet">
<link href="../css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/theme.default.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="../js/jquery.metadata.js"></script> 
<script src="../js/sales.js"></script>
</head>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="order_products">
		<h1>
				<center>Les ventes</center>
		</h1>
		<center><input type="button" id ="courbe" value ="Courbe" onclick="">
		<input type="button" id ="circular_graph" value ="Graphique circulaire" onclick="">
		<input type="button" id ="bar_graph" value ="Graphique en barres" onclick=""><br>
		<label id="lblprd">Produit : </label><select id="selectProduct"><option value="global">Tous</select>
		<p id="analyseVentes"></p>
		 <div id="chart_div"></div></center>
	</div>
</body>
</html>
