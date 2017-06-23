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
<script src="../js/stock_entry.js"></script> 
</head>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="saisie_stock">
		<h1>
				<center>Saisie des stocks</center>
		</h1>
		<center><div id = "stock_entry_form">   
			            <form method = "post" id="form_stock_entry" action = "https://fast-shore-70377.herokuapp.com/revendeur/stock/<?php echo $_SESSION['login'];?>">
			            <input type="hidden" name="_METHOD" value="PUT">
			                Stock produit A : <input type = "text" id = "stockProduitA" placeholder = "Stock produit A" name = "stockProduitA"><br>
			                Stock produit B : <input type = "text" id = "stockProduitB" name = "stockProduitB" placeholder = "Stock produit B">
			                <br><input type = "submit" id = "validerStock" value = "Actualiser stocks">
			                
			            </form>
			
			</div></center>
	</div>
</body>
</html>