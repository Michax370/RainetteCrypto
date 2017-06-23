<?php
use Mailgun\Mailgun;
class User{
	
	/**
	 * Fonction permettant de cr�er un user
	 * @param infos du user $infos
	 * @param bdd $db
	 * @return unknown
	 */
	public static function create($infos, $db){
		
		// Insertion dans la table revendeur
		$sql = "INSERT INTO revendeur (nom, login, prenom, numRue, rue, ville, cp, telephone, coordonneesX, coordonneesY, type_revendeur) VALUES (:nom, :login, :prenom, :numRue, :rue, :ville, :cp, :telephone, :coordonneesx, :coordonneesy, :type_revendeur)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("nom", $infos["nom"]);
		$stmt->bindParam("login", $infos["login"]);
		$stmt->bindParam("prenom", $infos["prenom"]);
		$stmt->bindParam("numRue", $infos["num_rue"]);
		$stmt->bindParam("rue", $infos["rue"]);
		$stmt->bindParam("ville", $infos["ville"]);
		$stmt->bindParam("ville", $infos["ville"]);
		$stmt->bindParam("coordonneesx", $infos["lat"]);
		$stmt->bindParam("coordonneesy", $infos["lng"]);
		$stmt->bindParam("cp", $infos["cp"]);
		$stmt->bindParam("telephone", $infos["num_tel"]);
		$stmt->bindParam("type_revendeur", $infos["type_revendeur"]);
		$stmt->execute();
		
		// Insertion dans la table revendeur
		$sql = "INSERT INTO user (login, password, type_user) VALUES (:login, :password, :type_user)";
		$stmt = $db->prepare($sql);
		$typeUser = 'revendeur';
		$stmt->bindParam("login", $infos["login"]);
		$password = password_hash($infos["password"], PASSWORD_DEFAULT);
		$stmt->bindParam("password", $password);
		$stmt->bindParam("type_user", $typeUser);
		$stmt->execute();
		$login = $infos["login"];
		$typeUserConnected = $typeUser;
		return array($login, $typeUserConnected);
		
	}
	
	/**
	 * Fonction permettant � un user de de se connecter
	 * @param infoUser $infos
	 * @param bdd $db
	 * @return 
	 */
	public static function login($infos, $db){
		$sql = "SELECT type_user,password FROM user WHERE login = :login";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("login", $infos["login"]);
		$stmt->execute();
		$row = $stmt->fetch();
		if(password_verify($infos["mdp"], $row['password'])){
			$_SESSION['login'] = $infos["login"];
			$_SESSION['typeUser'] = $row["type_user"];
			return true;
		}
		else{
			$_SESSION['connect'] = "Login/mot de passe invalide";
			return false;
		}
	}
	
	/**
	 * Fonction permettant de g�n�rer une cl� de s�curit� � la connexion
	 * @param infoUser $infos
	 * @param bdd $db
	 * @return
	 */
	public static function generateKey($infos, $db){
		$tfa = new RobThree\Auth\TwoFactorAuth(null,64,30,'sha1',null,null,null);
		$secret = $tfa->createSecret();
		$key = "key-352a1fcbfd81e4ff8dd77fe718075835";
		
		//Your credentials
		$mg = new Mailgun($key);
		$domain = "appcdc27cf5ea714b11bf129031202003df.mailgun.org";
		
		//Customise the email - self explanatory
		$mg->sendMessage($domain, array(
				'from'=>'postmaster@appcdc27cf5ea714b11bf129031202003df.mailgun.org',
				'to'=> 'benji77n@hotmail.fr',
				'subject' => 'Clé rainette',
				'text' => "Votre clé à inserer: ".$secret
		)
				);
		$sql = "UPDATE user SET token = :key WHERE login = :login ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("key", $secret) ;
		$stmt->bindParam("login", $infos['login']);
		$stmt->execute();
	}
	
	/**
	 * Fonction permettant de g�n�rer une cl� de s�curit� � la connexion
	 * @param infoUser $infos
	 * @param bdd $db
	 * @return
	 */
	public static function getKey($login, $db){
		
		$sql = "SELECT token FROM user WHERE login = :login ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("login", $login);
		$stmt->execute();
		$userKey = $stmt->fetch();
		return $userKey['token'];
	}
	
	/**
	 * Fonction de deconnexion du user
	 * @return unknown
	 */
	public static function logOut(){
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);
	}
}