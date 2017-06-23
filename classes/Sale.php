<?php
class Sale{
	
	/**
	 * Fonction permettant de récuperer toutes les ventes
	 * @param unknown $db
	 */
	public static function getAll($db){
		$sql = "SELECT date, quantite FROM commande WHERE etat =:etat ORDER BY date ASC";
		$stmt = $db->prepare($sql);
		$etat = 4;
		$stmt->bindParam("etat", $etat);
		$stmt->execute();
		$produits = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		return  json_encode($produits) ;
	}
	
	/**
	 * Fonction permettant de récuperer toutes les ventes
	 * @param unknown $db
	 */
	public static function getQteAll($db){
		$sql = "SELECT produit,SUM(quantite) AS qte FROM commande WHERE etat = :etat GROUP BY produit";
		$stmt = $db->prepare($sql);
		$etat = 4;
		$stmt->bindParam("etat", $etat);
		$stmt->execute();
		$produits = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		return  json_encode($produits) ;
	}
}