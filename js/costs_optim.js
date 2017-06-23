
//On appuie sur entrée pour saisir un nouveau nom de colonne
$(document).keypress(function(e) {

	if(e.which == 13) {
		var titre = $("#optim_couts .titre").val();
		$("#optim_couts thead tr:first-child th").eq(-2).html(titre);
		$("#optim_couts tbody tr:first-child th").eq(-2).html(titre);
	}
});

$( document ).ready(function() {

	// fonction permettant de récupérer le contenu du tableau des fournisseurs
	function getTableContent(){
		var arr = [],
		tmp;
		var i = 0;
		$('#optim_couts tbody tr').each(function() {

			tmp = {};

			$(this).each(function() {

				// Si la ligne est a enregistrer
				if ($(this).attr('class') == "toSave") {
					$(this).children().each(function() {
						if($(this).next().length != 0){
							var nomClass = $(this).attr('class').replace(/\s/g,'%20');
							tmp[nomClass] = $(this).text();
						}
						i++;
					});
					arr.push(tmp);
				}		
			});
		});
		return arr;

	}


	// appel ajax pour récupérer les produits pour recuperer les produits et faire des bouttons pour chaque produit
	$.ajax({
		type: 'GET',
		url: 'https://fast-shore-70377.herokuapp.com/product/all',
		contentType: "application/text",
		dataType: "text",
		success: function(response) {
			products = JSON.parse(response);
			i = 0;
			$.each( products, function( index, value ){
				$('#optim_couts_content #bouttonsProduits').append('<input type="button" id ="'+value["libelle"]+'" value ="'+value["libelle"]+'" class ="button_product">');
			});
			//appel ajax post pour inserer les fournisseurs et leur cout
			$('#optim_couts_content #bouttonsProduits .button_product').click(function() {
				$('#selectPaysDiv').append('<select id="selectPays"></select>')
				var pays = ["France", "Espagne", "Portugal"];

				// Affichage du select des pays lorsque qu'il y a eu un click sur un produit
				$.each( pays, function( index, value ){
					$('#selectPaysDiv #selectPays').append($("<option></option>")
							.attr("value",value)
							.text(value));
				});
				$('#tableOptim_couts').append('<table border="1px" id="optim_couts" class="tablesorter"><thead><tr><th>Nom Fournisseur</th><th><input type="text" class="titre"</th><th><input type="button" id="add_column" value="+" onclick="addColumn()"></input></th></tr></thead><tbody><tr><td><input type="text" class="row_fournisseur"></input></td><td><input type="text" class="info"></td><td><input type="button" class="add_row" value="&#x2713" onclick="saveRow()"></input></td></tr></tbody></table>');				
			});
		},
		error: function(error) {
			console.log(error);
		}
	});

	//appel ajax post pour inserer les fournisseurs et leur informations
	$( "#usine_prix" ).click(function() {
		var arrayContent = getTableContent();
		var arrayContentJson = JSON.stringify(arrayContent);
		var paysSelected = $('#selectPays').val();
		$.ajax({
	        type: 'POST',
	        url: 'https://fast-shore-70377.herokuapp.com/fournisseur/cout',
			data : {tabFournisseur : arrayContentJson, pays : paysSelected},
	        success: function(response) {
	        	console.log(response);
	        },
	        error: function(error) {
	            alert("Erreur lors de l'enregistrement des commandes "+error);
	        }
		});
	});
});

	/**
	 * Fonction qui permet d'ajouter des lignes à chaque fois que le boutton d'enregistrement est appuyé
	 * @returns
	 */
	function saveRow(){

		var infos = [];
		var fournisseur = "";
		var prix = "";

		// Recuperation des valeurs des cellues de la ligne a enregistrer
		$('#optim_couts tbody tr:last').find('td').each (function() {
			if($(this).find('input').hasClass('row_fournisseur')){
				fournisseur = $('.row_fournisseur').val();
			}
			if($(this).find('input').hasClass('info')){
				var info = $(this).find('.info').val();
				infos.push(info);
			}
		});  

		// on enregistre la ligne du nom du fournisseur
		$("#optim_couts tbody tr:last td:first-child").html(fournisseur);
		// on ajout la classe pour le futur enregistrement
		$("#optim_couts tbody tr:last td:first-child").addClass('fournisseur');

		var i = 0;
		
		// On recupére les autres colonnes
		$.each( infos, function( index, value ) {
			var titre = $("#optim_couts thead tr th").eq(index+1).html();
			$("#optim_couts tbody tr:last td").eq(index+1).addClass(titre);
			$("#optim_couts tbody tr:last td").eq(index+1).html(value);
			i = index;
		});
		$("#optim_couts tbody tr:last").addClass("toSave");
		// On recréer une nouvelle ligne pour la saisie dans la tableau
		$("#optim_couts tbody tr:last td:last input").remove(".add_row");
		$('#optim_couts tbody').append('<tr><td><input type="text" class="row_fournisseur"></input></td>');

		var j = 0;
		while(j != i+1){
			$('#optim_couts tbody tr:last').append('<td><input class="info"></td>');
			j++
		}

		$('#optim_couts tbody tr:last').append('<td><input type="button" class="add_row" value="&#x2713" onclick="saveRow()"></input></td></tr>');

		// Affichage du boutton pour passer l'étape suivante 
		$('#usine_prix').show();
	}

	/**
	 * Fonction qui permet d'ajouter des colonnes lorsque le boutton + est appuyé
	 * @returns
	 */
	function addColumn(){
		$('#optim_couts thead tr:first-child th:last-child').before('<th><input type="text" class="titre"></th>');
		$('#optim_couts tbody tr:last-child td:last-child').before('<td><input type="text" class="info"></td>');

	}

