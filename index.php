<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
include('config/config.php');
include('classes/Revendeur.php');
include('classes/Sale.php');
include('classes/User.php');
include('classes/Product.php');
include('classes/Fournisseur.php');

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response) {
	$erreur ="";
	session_start();
	if(isset($_SESSION['login'])){
		$display1 = "display:block";
		$display2 = "display:none";
		$display3 = "display:none";
		$connectedAs = 'Connecté en tant que '.$_SESSION['login'];
		// Menu admin
		if(isset($_SESSION['typeUser']) && $_SESSION['typeUser'] == 'admin'){
			$menu = '<ul>
			<li id="map"><a href="views/map.php">Carte interactive</a></li>
			<li id="sales_entry"><a href="views/sales_entry.php">Saisir les ventes</a></li>
			<li id="table"><a href="views/stats.php">Tableaux et classements</a></li>
			<li id="optim_cout"><a href="views/costs_optim.php">Optmisation des coûts</a></li>
			<li id="ventes"><a href="views/sales.php">Voir les ventes</a></li>
			<li id="deconnexion"><a href="user/logout">Se déconnecter</a></li>
			</ul>';
		}
		// Menu revendeur
		else{
			$menu = '<ul>
			<li id="map"><a href="views/stock_entry.php">Saisir stocks</a></li>
			<li id="table"><a href="views/order_products.php">Commander des produits</a></li>
			<li id="optim_cout"><a href="views/update_infos.php">Actualiser infos</a></li>
			<li id="deconnexion"><a href="user/logout">Se déconnecter</a></li>
			</ul>';
		}
		
	}
	else{
		$connectedAs = 'Non connecté';
		$display2 = "display:block";
		$display1 = "display:none";
		$display3 = "display:none";
		if(isset($_SESSION['connect'])){
			$display3 = "display:block";
			$erreur = $_SESSION['connect'];
		}
		$menu ="";
	}
	echo '<html>
	<head>
	 <meta charset="utf-8"/>
	   <title>Rainette</title>
	   <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
	   <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	   <link href="css/style.css" rel="stylesheet">
	   <link href="css/mystyle.css" rel="stylesheet">
	   <link href="css/style-xlarge.css" rel="stylesheet">
	   <link href="css/font-awesome.min.css" rel="stylesheet">
	</head>
		<body>
			<div id="logo"></div>
			<div class="content">
			<p id="bienvenue">Bienvenue sur l\'application Web de Rainette !</p>
			<div id ="menu" style="'.$display1.'">
				<nav>'.$menu.'
					
			   </nav>
			</div>
			<div id="connectedAs">'.$connectedAs.'
			</div>
			<center>
			 <div id = "loginform" style="'.$display2.'">
			 <p  style="'.$display3.'" id="erreur">'.$erreur.'</p>        
			            <form method = "post" action = "user/login">
			                <p>Se connecter</p>
			                <input type = "text" id = "login" placeholder = "Login" name = "login">
			                <input type = "password" id = "password" name = "mdp" placeholder = "Mot de passe">
							<input type = "button" id = "create_account" value = "Créer compte"  onclick="window.location.href=\'/views/create_account.php\'"><br>
			                <input type = "submit" id = "dologin" value = "Connexion">
			            </form>
			
			</div>
			</center>
		</div>
		</body>
</html>';
	
exit();
});

// Ws pour recuperer les emplacements geo des revendeurs
$app->get('/map/revendeurs', function (Request $request, Response $response) {
	try{
		$db = getConnection();
		echo Revendeur::getAll($db);
		exit();
	}
	catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
    }
	
});
// WS de login
$app->post('/user/login', function (Request $request, Response $response) {
	try{
		session_start();
		$db = getConnection();
		$allPostPutVars = $request->getParsedBody();
		if(User::login($allPostPutVars, $db) == true){
			User::generateKey($allPostPutVars, $db);
			$keyFromBdd = User::getKey($allPostPutVars["login"], $db);
			echo  '<head>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			</head>';
			echo '<input type = "hidden" id="key" value="'.$keyFromBdd.'">';
			echo '<script type="text/javascript">
			var name=prompt("Entrez votre clé de sécurité: ","");
			if(name == document.getElementById("key").value){
				document.location = "https://fast-shore-70377.herokuapp.com/";}
			else{
				alert("Erreur dans la clé - Retour à l\'écran de connexion !");
				$.ajax({
					type: "GET",
					url: "https://fast-shore-70377.herokuapp.com/user/logout",
					contentType: "application/text",
					dataType: "text",
					success: function(response) {
						document.location = "https://fast-shore-70377.herokuapp.com/";
					},
					error: function(error) {
						console.log(error);
					}
				});
			}
					
			</script>'
			;
			//return $response->withStatus(302)->withHeader('Location', URL_APPLI);
			exit();
		}
		else{
			return $response->withStatus(302)->withHeader('Location', URL_APPLI);
			exit();
		}
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});

// WS de login
$app->post('/user/loginmobile', function (Request $request, Response $response) {
	try{
		session_start();
		$db = getConnection();
		$allPostPutVars = $request->getParsedBody();
		if(User::login($allPostPutVars, $db) == true){
			echo '[{"login":"'.$allPostPutVars['login'].'", "mdp":"'.$allPostPutVars['mdp'].'"}]';
			exit();
		}
		else{
			return $response->withStatus(204);
			exit();
		}
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});
	
// WS de création de compte revendeur
$app->post('/user/create', function (Request $request, Response $response) {
	try{
		session_start();
		$db = getConnection();
		$allPostPutVars = $request->getParsedBody();
		$arrayConnect = User::create($allPostPutVars, $db);
		$_SESSION['login'] = $arrayConnect[0];
		$_SESSION['typeUser'] = $arrayConnect[1];
		return $response->withStatus(302)->withHeader('Location', 'https://fast-shore-70377.herokuapp.com/');
		exit();
		
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});

// WS permettant de renvoyer le tableaux des stats des revendeurs
$app->get('/revendeur/stats', function (Request $request, Response $response) {
	try{
		$db = getConnection();
		echo Revendeur::getStats($db);
		exit();
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
});

//WS permettant de renvoyer le tableaux des stats des revendeurs en fonction de leur type
$app->get('/revendeur/stats/{type}', function (Request $request, Response $response) {
		$type = $request->getAttribute('type');
		try{
			$db = getConnection();
			echo Revendeur::getStatsOfType($db, $type);
			exit();
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			exit();
		}
});
//WS permettant le logout
$app->get('/user/logout', function (Request $request, Response $response) {
	User::logOut();
	return $response->withStatus(302)->withHeader('Location', 'https://fast-shore-70377.herokuapp.com/');
	exit();
});

// WS permettant de récuperer les infos d'un revendeur
$app->get('/revendeur/{id}', function (Request $request, Response $response) {
	$id = $request->getAttribute('id');
	try{
		$db = getConnection();
		echo Revendeur::getInfoRevendeur($db, $id);
		exit();
	}
	catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
    }
});

// WS permettant d'inserer les couts des fournisseurs de matieres premiers
$app->post('/fournisseur/cout', function (Request $request, Response $response) {
	$allPostPutVars = $request->getParsedBody();
	$res = json_decode($allPostPutVars['tabFournisseur'], true);
	$db = getConnection();
	$pays = $allPostPutVars['pays'];
	try{
		echo Fournisseur::addCostArray($res, $db, $pays);
		exit();
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
});

// WS permettant d'envoyer le mail avec la commande du revendeur avec la quantite et les produits
$app->post('/revendeur/mailcommande', function (Request $request, Response $response) {
	$allPostPutVars = $request->getParsedBody();
	session_start();
	try{    
		Revendeur::mailCommande($allPostPutVars['commande']);
		exit();
		
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
});
// WS permettant d'inserer les ventes des revendeurs
$app->post('/revendeur/commande', function (Request $request, Response $response) {
	$allPostPutVars = $request->getParsedBody();
	try{
		
		$db = getConnection();
		echo Revendeur::addCommande($allPostPutVars['commandes'], $db);
		exit();
		
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
});
	
// WS de saisie des stocks pour les revendeurs
	$app->put('/revendeur/stock/{login}', function (Request $request, Response $response) {
	try{
		
		session_start();
		$allPostPutVars = $request->getParsedBody();
		// recuperation des vars du form
		$stockProduitA = $allPostPutVars['stockProduitA'];
		$stockProduitB = $allPostPutVars['stockProduitB'];
		$login = $request->getAttribute('login');
		$db = getConnection();
		Revendeur::addStocks($db, $login, $stockProduitA, $stockProduitB);
		exit();
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});
	
	
// WS de maj des données du revendeur
$app->put('/revendeur/update/{login}', function (Request $request, Response $response) {
	try{
		
		session_start();
		$db = getConnection();
		$allPostPutVars = $request->getParsedBody();
		$login = $request->getAttribute('login');
		Revendeur::updateInfos($db, $allPostPutVars, $login);
		exit();
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});
// WS de recupération des produits
$app->get('/product/all', function (Request $request, Response $response) {
	try{
		
		$db = getConnection();
		echo Product::getAll($db);
		exit();
	}
	catch(Exception $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});
// WS de tracage des courbes de ventes
$app->get('/sales/quantite', function (Request $request, Response $response) {
	try{
		$db = getConnection();
		echo Sale::getQteAll($db);
		exit();
	}
	catch(Exception $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});
// WS de tracage des courbes de ventes
$app->get('/sales/all', function (Request $request, Response $response) {
	try{
		$db = getConnection();
		echo Sale::getAll($db);
		exit();
	}
	catch(Exception $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		exit();
	}
	
});
$app->run();
function getConnection() {
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>

