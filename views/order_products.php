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
<script src="../js/jquery.metadata.js"></script> 
<script src="../js/order_products.js"></script>
</head>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="order_products">
		<h1>
				<center>Commande de produits</center>
		</h1>
		<table border="1px" id="orderProductsTable" class="tablesorter">
		<thead>
			<tr>
				<th>Produit</th>
				<th>Quantité</th>
				<th>Couleur</th>
			</tr>
		</thead>
		<tbody></tbody>
		</table>
		<center><input type="button" id ="commander_produits" value ="Commander" ></input></center>
	</div>
</body>
</html>