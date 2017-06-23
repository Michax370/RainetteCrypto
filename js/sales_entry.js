$( document ).ready(function() {
	
	// on ajoute le datepicker
	$( "#date" ).datepicker();

	// alimentation du tableau remplissage des revendeurs
	$.ajax({
		type: 'GET',
		url: 'https://fast-shore-70377.herokuapp.com/map/revendeurs',
		contentType: "application/text",
		dataType: "text",
		success: function(response) {
			row = JSON.parse(response);
			var i = 0;
			$.each( row["revendeur"], function( index, value ){
				$('#sales_entry #revendeur').append($("<option></option>")
						.attr("value",value["nom"])
						.text(value["nom"])); 
			});

		},
		error: function(error) {
			console.log(error);
		}
	});

	// alimentation du tableau remplissage des produits
	$.ajax({
		type: 'GET',
		url: 'https://fast-shore-70377.herokuapp.com/product/all',
		contentType: "application/text",
		dataType: "text",
		success: function(response) {
			row = JSON.parse(response);
			var i = 0;
			$.each( row, function( index, value ){
				$('#sales_entry #produit').append($("<option></option>")
						.attr("value",value["libelle"])
						.text(value["libelle"])); 
			});

		},
		error: function(error) {
			console.log(error);
		}
	});

	// fonction permettant de récupérer le contenu du tableau des commandes
	function getTableContent(){
		var arr = [],
		tmp;

		$('#sales_entryTable tbody tr').each(function() {

			tmp = {};

			$(this).each(function() {

				if ($(this).attr('class') == "toSave") {
					$(this).children().each(function() {
						if($(this).attr('class') != "addrow"){
							tmp[$(this).attr('class')] = $(this).text();
						}
					});
				}

			});

			arr.push(tmp);
		});

		return arr;

	}
	
	
	// appel ajax permettant d'inserer les commandes en bdd
	$( "#sales_entry_save" ).click(function() {
		var arrayContent = getTableContent();
		var arrayContentJson = JSON.stringify(arrayContent);
		$.ajax({
	        type: 'POST',
	        url: 'https://fast-shore-70377.herokuapp.com/revendeur/commande',
			data : {commandes : arrayContentJson},
	        success: function(response) {
	        	
	        	/*if(confirm("Commandes enregistrees - Redirection vers le menu principal !")){

	        		document.location = "https://fast-shore-70377.herokuapp.com/";
	        	}*/
	        },
	        error: function(error) {
	            alert("Erreur lors de l'enregistrement des commandes "+error);
	        }
		});
	});
});



/**
 * Fonction qui permet d'ajouter des lignes à chaque fois que le boutton + est appuyé
 * @returns
 */
function addRow(){
	var i = 0;
	var valueSelectRevendeur = [];
	var valueSelectProduit = [];
	$("#sales_entryTable #revendeur option").each(function()
			{
		valueSelectRevendeur.push($(this).val());
			});

	$("#sales_entryTable #produit option").each(function()
			{
		valueSelectProduit.push($(this).val());
			});

	var revendeur = $("#sales_entryTable tbody tr:last td #revendeur").val();
	var produit = $("#sales_entryTable tbody tr:last td #produit").val();
	var qte = $("#sales_entryTable tbody tr:last td #qte").val();
	var date = $("#sales_entryTable tbody tr:last td #date").val();
	var montant = $("#sales_entryTable tbody tr:last td #montant").val();
	$("#sales_entryTable tbody tr:last td:first-child").html(revendeur);
	$("#sales_entryTable tbody tr:last td:nth-child(2)").html(produit);
	$("#sales_entryTable tbody tr:last td:nth-child(3)").html(qte);
	$("#sales_entryTable tbody tr:last td:nth-child(4)").html(montant);
	$("#sales_entryTable tbody tr:last td:nth-child(5)").html(date);
	$("#sales_entryTable tbody tr:last td:last input").remove("#add_row");
	$("#sales_entryTable tbody tr:last").addClass("toSave");
	$('#sales_entryTable tbody').append('<tr><td class="revendeur"><select id="revendeur" ></select></td><td class="produit"><select id="produit" ></select></td><td class="qte"><input type="text" id="qte"></input></td><td class="montant"><input type="text" id="montant"></input><td><input type="text" id="date"></input></td><td class="addrow"><input type="button" id="add_row" value="+" onclick="addRow()"></input></td></tr>');

	$.each(valueSelectRevendeur, function( index, value ) {
		$('#sales_entry tbody tr:last #revendeur').append($("<option></option>")
				.attr("value",value)
				.text(value)); 
	});

	$.each(valueSelectProduit, function( index, value ) {
		$('#sales_entry tbody tr:last #produit').append($("<option></option>")
				.attr("value",value)
				.text(value)); 
	});
	i++;
	// on affiche le boutton pour enregistrer
	if(i == 1){
		$('#sales_entry_save').show();
	}

}
