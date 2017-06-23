<?php
class Product{
	
	/**
	 * Function permettant de récuper tous les produits
	 * @param bdd $db
	 * @return string
	 */
	public static function getAll($db){
		$sql = "SELECT * FROM produit";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$produits = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		return json_encode($produits);
	}
}