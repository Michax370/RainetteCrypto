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
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script> 
<script src="../js/jquery.metadata.js"></script> 
<script src="../js/stats.js"></script>
</head>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="stats_content">
		<h1>
			<center>Tableaux et classements
		
		</h1>
		
		<div id="connectedAs" style="margin-top: -271px;">Connecté en tant que <?php echo $_SESSION['login'];?></div>
		
		<div class="buttons">
			<input type="button" id="revendeurs_general" value="Général" />
			<input type="button" id="revendeurs_phy" value="Revendeurs physiques" />
			<input type="button" id="revendeurs_web" value="Revendeurs Web" />
		</div>
		<table border="1px" id="stats" class="tablesorter">
		<thead>
			<tr>
				<th>Nom revendeur</th>
				<th>Zone géographique</th>
				<th>Chiffre d'affaire</th>
				<th>Produit le plus vendu</th>
			</tr>
		</thead>
		<tbody></tbody>
		</table>
	</div>
</body>
</html>