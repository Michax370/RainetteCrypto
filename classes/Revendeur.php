<?php
use Mailgun\Mailgun;
class Revendeur {
	
	/**
	 * Méthode permettant de récupérer tous les revendeurs
	 * 
	 * @param bdd $db        	
	 * @return string
	 */
	public static function getAll($db) {
		$sql = "SELECT * FROM revendeur";
		$stmt = $db->prepare ( $sql );
		$stmt->execute ();
		$revendeurs = $stmt->fetchAll ( PDO::FETCH_OBJ );
		$db = null;
		return '{"revendeur": ' . json_encode ( $revendeurs ) . '}';
	}
	
	
	/**
	 * Fonction qui retourne un tableau des revendeurs avec leur produit le plus vendu
	 * @ param typeRevendeur array
	 * @ param bdd db
	 * @return array
	 */
	public static function getProduitPlusVendu($typeRevendeur = array('web','physique'), $db){
		
		// création de la view permettant de récupérer le total des ventes de chaque produit pour chaque revendeur (etat = 4 = commandes finalisée)
		$ids_string = implode(',', $typeRevendeur);
		$sql = "Create or replace view result AS
			SELECT c.produit,c.id_revendeur,SUM(c.quantite) as qte,type_revendeur AS type_revendeur
			FROM commande c, revendeur r WHERE c.id_revendeur = r.id
			AND FIND_IN_SET (r.type_revendeur ,:typeRevendeur) AND c.etat = 4 GROUP BY id_revendeur,produit ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("typeRevendeur", $ids_string);
		$stmt->execute();
		// recupération du produit le plus vendu pour chaque revendeur
		$sql = "select id_revendeur, produit
			from result where (id_revendeur, qte) in (select id_revendeur, max(qte)
			from result group by id_revendeur) ";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$revendeurs = $stmt->fetchAll(PDO::FETCH_OBJ);
		$res = array();
		$i = 0;
		foreach($revendeurs as $rev ){
			$nomRev = Revendeur::getNomRevendeur($rev->id_revendeur, $db);
			$res[$i]['nom'] = $nomRev;
			$res[$i]['produit'] = $rev->produit;
			$i++;
			
		}
		return $res;
	}
	
	/**
	 * Fonction permettant de récuperer les stats de ventes des revendeurs
	 * 
	 * @param bdd $db        	
	 * @return string
	 */
	public static function getStats($db) {
		$arrayRes = array ();
		$sql = "SELECT r.nom,r.zoneGeo,TRUNCATE(SUM(c.montant),1) as ca
							   FROM commande c, revendeur r
                               WHERE c.id_revendeur = r.id GROUP BY id_revendeur";
		$stmt = $db->prepare ( $sql );
		$stmt->execute ();
		$revendeurs = $stmt->fetchAll ( PDO::FETCH_OBJ );
		
		$revendeursProduit = self::getProduitPlusVendu (array('web','physique'), $db);
		$arrayRes [0] = $revendeurs;
		
		$arrayRes [1] = $revendeursProduit;
		
		$db = null;
		return '{"revendeur": ' . json_encode ( $arrayRes ) . '}';
	}
	
	/**
	 * Fonction permettant de recupérer les stats de ventes d'un type de revendeur
	 * 
	 * @param bdd $db        	
	 * @param typeRevendeur $type        	
	 * @return string
	 */
	public static function getStatsOfType($db, $type) {
		$arrayRes = array ();
		$sql = "SELECT r.nom,r.zoneGeo,TRUNCATE(SUM(c.montant),1) as ca
							   FROM commande c, revendeur r
                               WHERE c.id_revendeur = r.id
							   AND type_revendeur = :typeRevendeur
							   GROUP BY id_revendeur";
		$stmt = $db->prepare ( $sql );
		$stmt->bindParam ( "typeRevendeur", $type );
		$stmt->execute ();
		$revendeurs = $stmt->fetchAll ( PDO::FETCH_OBJ );
		$revendeursProduit = self::getProduitPlusVendu ( array ($type), $db);
		$arrayRes [0] = $revendeurs;
		$arrayRes [1] = $revendeursProduit;
		$db = null;
		return '{"revendeur": ' . json_encode ( $arrayRes ) . '}';
	}
	
	/**
	 * Fonction permettant de récuperer les infos d'un revendeur en lui fournissant son id ou son no
	 * 
	 * @param
	 *        	id ou nom du revendeur $id
	 * @return string
	 */
	public static function getInfoRevendeur($db, $id) {
		// si on recupere les infos par l'id du revendeur
		if (ctype_digit ( $id )) {
			$sql = "SELECT * FROM revendeur WHERE id = :id";
		}		// Si on recupere les infos par le login du revendeur
		else {
			$sql = "SELECT * FROM revendeur WHERE login = :id";
		}
		$stmt = $db->prepare ( $sql );
		$stmt->bindParam ( "id", $id );
		$stmt->execute ();
		$revendeurs = $stmt->fetchAll ( PDO::FETCH_OBJ );
		$db = null;
		return '{"revendeur": ' . json_encode ( $revendeurs ) . '}';
	}
	
	/**
	 * Fonction qui permet d'envoyer le mail de commande des revendeurs
	 * 
	 * @param
	 *        	commande du revendeur format json $commande
	 */
	public static function mailCommande($commande) {
		$key = "key-352a1fcbfd81e4ff8dd77fe718075835";
		
		$var = json_decode ( $commande, true );
		$mail = "Je souhaiterais vous faire une commande pour : \n";
		foreach ( $var ['produits'] as $row ) {
			$mail .= $row ['libelle'] . " " . $row ['couleur'] . " x" . $row ['qte'] . "\n";
		}
		$mail .= "Cordialement,\n" . $_SESSION ['login'] . ".";
		
		//Your credentials
		$mg = new Mailgun($key);
		$domain = "appcdc27cf5ea714b11bf129031202003df.mailgun.org";
		
		//Customise the email - self explanatory
		$mg->sendMessage($domain, array(
				'from'=>'postmaster@appcdc27cf5ea714b11bf129031202003df.mailgun.org',
				'to'=> 'benji77n@hotmail.fr',
				'subject' => 'The PHP SDK is awesome!',
				'text' => $mail
		)
				);
	}
	
	/**
	 * Fonction qui retourne le nom du revendeur en lui fournissant une id
	 * @param  $id id du revendeur
	 * @return nom du revendeur
	 */
	public static function getIdRevendeur($db, $nom){
		$sql = "select id FROM revendeur WHERE nom= :nom";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("nom", $nom);
		$stmt->execute();
		$revendeurs = $stmt->fetch();
		return $revendeurs['id'];
	}
	
	/**
	 * Fonction qui d'enregistrer une commande faite à un revendeur
	 * 
	 * @param
	 *        	commande du revendeur format json $commande
	 */
	public static function addCommande($commande, $db) {
		$res = json_decode ( $commande);
		$res2 = array_pop ( $res );
		foreach ( $res as $row ) {
			// requete d'update des stock du revendeur
			$sql = "INSERT INTO commande (date, montant,etat,produit,quantite, id_revendeur) VALUES (:date, :montant, :etat, :produit, :quantite, :id_revendeur)";
			$stmt = $db->prepare ( $sql );
			$dateInput = explode ( '/', $row->date );
			$dateFormated = $dateInput [2] . '-' . $dateInput [0]. '-' .$dateInput [1];
			$stmt->bindParam ( "date", $dateFormated );
			$stmt->bindParam ( "montant", $row->montant );
			$etat = 4;
			$stmt->bindParam ( "etat", $etat );
			$stmt->bindParam ( "produit", $row->produit );
			$stmt->bindParam ( "quantite", $row->qte );
			$id = self::getIdRevendeur($db, $row->revendeur);
			$stmt->bindParam ( "id_revendeur", $id );
			$val = $stmt->execute ();
			
		}
	}
	
	/**
	 * Fonction permettand d'actualiser les stocks d'un revendeur grace a son login
	 * @param bdd $db
	 * @param login du revendeur $login
	 * @param stockProduit A $stockProduitA
	 * @param stockProduit B $stockProduitB
	 */
	public static function addStocks($db, $login, $stockProduitA, $stockProduitB){
		// requete d'update des stock du revendeur
		$sql = "UPDATE revendeur SET stockProduitA = :stockProduitA,stockProduitB = :stockProduitB WHERE login = :login ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("stockProduitA", $stockProduitA);
		$stmt->bindParam("stockProduitB", $stockProduitB);
		$stmt->bindParam("login", $login);
		$stmt->execute();
		$message='Stocks actualises - Redirection vers le menu principal !';
		
		// on redirige vers le menu principale aprés l'insertion des données dans la base
		echo '<script type="text/javascript">if(confirm("'.$message.'")) document.location = "https://fast-shore-70377.herokuapp.com/";</script>';
	}
	
	/**
	 * Fonction permettant d'actualiser les infos d'un revendeur grace à son login
	 * @param bdd $db
	 * @param infos a actualiser $infos
	 * @param login du revendeur $login
	 */
	public static function updateInfos($db, $infos, $login){
		// recuperation des vars du form
		$nom = $infos['nom'];
		$prenom = $infos['prenom'];
		$ville = $infos['ville'];
		$cp = $infos['cp'];
		$rue = $infos['rue'];
		$numRue = $infos['num_rue'];
		$tel = $infos['num_tel'];
		
		// requete d'update des informations du revendeur
		$sql = "UPDATE revendeur SET nom = :nom, prenom = :prenom, ville = :ville, cp = :cp, rue = :rue, numRue = :numRue, telephone = :tel WHERE login = :login ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("nom", $nom);
		$stmt->bindParam("prenom", $prenom);
		$stmt->bindParam("ville", $ville);
		$stmt->bindParam("cp", $cp);
		$stmt->bindParam("rue", $rue);
		$stmt->bindParam("numRue", $numRue);
		$stmt->bindParam("tel", $tel);
		$stmt->bindParam("login", $login);
		$stmt->execute();
		$message='Informations actualisees - Redirection vers le menu principal !';
		
		// on redirige vers le menu principale aprés l'insertion des données dans la base
		echo '<script type="text/javascript">if(confirm("'.$message.'")) document.location = "https://fast-shore-70377.herokuapp.com/";</script>';
	}
	
	
	/**
	 * Fonction qui retourne le nom du revendeur en lui fournissant une id
	 * @param  $id id du revendeur
	 * @return nom du revendeur
	 */
	public static function getNomRevendeur($id, $db){
		$sql = "select nom FROM revendeur WHERE id= :id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$revendeurs = $stmt->fetch();
		return $revendeurs['nom'];
	}
}