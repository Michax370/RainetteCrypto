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
<script type="text/javascript" src="../js/costs_optim.js"></script>
</head>
<div id="logo"></div>
<input type="button" id ="back_to_menu" value ="Retour menu principal" onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="optim_couts_content">
		<h1>
			<center>Optimisation des coûts
		
		</h1>
		<div id="connectedAs" style="margin-top: -271px;">Connecté en tant que <?php echo $_SESSION['login'];?></div>
		<center><div id="bouttonsProduits"></div></center>
		<center><div id="selectPaysDiv"></div></center>
		<div id="tableOptim_couts"></div>
		<center><input type="button" id ="usine_prix" value ="Validet et saisir les prix d'usine" style="display:none"></input></center>
	</div>
</body>
</html>