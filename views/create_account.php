<?php
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
<script src="../js/create_account.js"></script>
</head>
<div id="logo"></div>
<input type="button" id="back_to_menu" value="Retour menu principal"
	onclick="location.href='https://fast-shore-70377.herokuapp.com'">
<body>
	<div id="create_account">
		<h1>
			<center>Création de compte revendeur</center>
		</h1>
			<form method="post" action="https://fast-shore-70377.herokuapp.com/user/create" id="createAccountForm"> 
							<label>Nom :</label><input type = "text" id = "nom" placeholder = "nom" name = "nom">
			                <label>Prénom : </label><input type = "text" id = "prenom" name = "prenom" placeholder = "prenom">
			                <label>Ville : </label><input type = "text" id = "ville" name = "ville" placeholder = "ville">
			                <input type = "hidden" id = "lng" name = "lng">
			                <input type = "hidden" id = "lat" name = "lat">
			                <label>Code Postal : </label><input type = "text" id = "cp" name = "cp" placeholder = "CP">
			                <label>Rue : </label><input type = "text" id = "rue" name = "rue" placeholder = "rue">
			                <label>N° rue : </label><input type = "text" id = "num_rue" name = "num_rue" placeholder = "num�ro rue">
			                <label>N° téléphone : </label><input type = "text" id = "num_tel" name = "num_tel" placeholder = "num�ro tel">
			                <label>Type revendeur : </label><select id="type_revendeur" name="type_revendeur"><option value="Web">Web<option value="Physique">Physique</select>
			                <label>Login : </label><input type = "text" id = "login" name = "login" placeholder = "login">
			                <label>Mot de passe : </label><input type = "password" id = "password" name = "password" placeholder = "Mot de passe">
			                <label>Confirmation mot de passe : </label><input type = "password" id = "passconfirm" name = "passconfirm" placeholder = "Confirmation mdp">
				<input type="submit" id="createAccount" value="Cr�er compte">
			</form>
	</div>
</body>
</html>