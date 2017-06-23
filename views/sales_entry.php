<?php
session_start ();

?>
<!DOCTYPE HTML>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../js/sales_entry.js"></script> 
<script src="../js/jquery.metadata.js"></script> 
</head>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="sales_entry">
		<h1>
				<center>Saisir les ventes</center>
		</h1>
		<table border="1px" id="sales_entryTable" class="tablesorter">
		<thead>
			<tr>
				<th>Revendeur</th>
				<th>Produit</th>
				<th>Quantité</th>
				<th>Montant</th>
				<th>Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
					<td class ="revendeur" ><select id="revendeur" ></select></td>
					<td class ="produit" ><select id="produit" ></select></td>
					<td class ="qte" ><input type="text" id="qte"></input></td>
					<td class ="montant" ><input type="text" id="montant"></input></td>
					<td class ="date" ><input type="text" id="date"></input></td>
					<td class ="addrow"><input type="button" id="add_row" value="+" onclick="addRow()"></input></td>
			</tr>
		</tbody>
		</table>
		<center><input type="button" id ="sales_entry_save" value ="Enregistrer" style="display:none"></input></center>
		
	</div>
</body>
</html>
