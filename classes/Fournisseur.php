<?php
class Fournisseur{
	
	public static function addCostArray($tabCost, $db, $pays){
		$arrayValues = array();
		$ligneValues = array();
		$arrayColumn = array();
		$i = 0;
		
		// Ajout des colonnes et stockages des values 
		foreach($tabCost as $row){
			$arrayValues = array();
			foreach($row as $key => $value) {
				if($i == 0){
					$keyFormated = str_replace("%20", "_", $key);
					$sql = "ALTER TABLE fournisseur ADD ".$keyFormated." VARCHAR(50)";
					$db->exec($sql);
				}
				array_push($arrayValues, $value);
			}
			array_push($ligneValues, $arrayValues);
			$i++;
		}
		$tabQuery = array();
		$query = "";
		$j = 0;
		
		// on constitue la chaine qui permettra d'inserer les values 
		foreach($ligneValues as $tab){
			$query = "";
			foreach($tab as $val){
				$query .= "'".$val."',";
				$tabQuery[$j] = $query;
			}
			$queryFormated = substr($query, 0, -1).")"; 
			$tabQuery[$j] = $queryFormated;
			$j++;
		}
		foreach($tabQuery as $queryValues){
			$sql = "INSERT INTO fournisseur VALUES('','".$pays."',".$queryValues;
			print_r($sql);
			$db->exec($sql);
		}
	}
}