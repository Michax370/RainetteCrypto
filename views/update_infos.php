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
		<script src="../js/update_infos.js"></script>
	</head>
	<div id="logo"></div>
	<input type="button" id="back_to_menu" value="Retour menu principal"
		onclick="location.href='https://fast-shore-70377.herokuapp.com'">
	<body>
		<div id="update_infos">
			<h1>
						<center>Actualiser mes informations</center>
			</h1>
			<div id="formUpdateInfos">
			<center><form method = "post" id="form_update_infos" action = "https://fast-shore-70377.herokuapp.com/revendeur/update/<?php echo $_SESSION['login'];?>">
			            <input type="hidden" name="_METHOD" value="PUT">
			            <input type="hidden" id="current_login" name="login" value=<?php echo $_SESSION['login'];?>>
			                <label>Nom :</label><input type = "text" id = "nom" placeholder = "nom" name = "nom">
			                <label>Prénom : </label><input type = "text" id = "prenom" name = "prenom" placeholder = "prenom">
			                <label>Ville : </label><input type = "text" id = "ville" name = "ville" placeholder = "ville">
			                <label>Code Postal : </label><input type = "text" id = "cp" name = "cp" placeholder = "CP">
			                <label>Rue : </label><input type = "text" id = "rue" name = "rue" placeholder = "rue">
			                <label>N° rue : </label><input type = "text" id = "num_rue" name = "num_rue" placeholder = "num_rue">
			                <label>N° téléphone : </label><input type = "text" id = "num_tel" name = "num_tel" placeholder = "num_tel">
			                <input type = "submit" id = "valider_update_infos" value = "Valider">
			                
            </form></center></div>
		</div>
	</body>
</html>