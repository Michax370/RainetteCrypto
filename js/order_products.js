$( document ).ready(function() {

	function nbOfOccurence(string){
		var temp = string;
		var count = (temp.match(/,/g) || []).length;
		return count;
	}
	
	
	// appel ajax pour récupérer les produits et leur prix
	$.ajax({
		type: 'GET',
		url: 'https://fast-shore-70377.herokuapp.com/product/all',
		contentType: "application/text",
		dataType: "text",
		success: function(response) {
			products = JSON.parse(response);
			i = 0;
			$.each( products, function( index, value ){
				var couleur = value["couleur"];
				var tabCouleur  = couleur.split(",");
				var res = nbOfOccurence(couleur);
				$('#orderProductsTable tbody').append('<tr><td>'+value['libelle']+'</td><td class="qte_'+value['libelle']+'"+><input type="text" id="quantite_prod_'+i+'"></input></td><td><select id="couleur_'+value['libelle']+'"</select></td></tr>');
				for(j=0; j<res+1; j++){
					$('#orderProductsTable #couleur_'+value["libelle"]).append($("<option></option>")
							.attr("value",tabCouleur[j])
							.text(tabCouleur[j])); 
				}
				i++;
			});

		},
		error: function(error) {
			console.log(error);
		}
	});

	// On envoie la commande du revendeur au click sur le bouton commander
	$( "#commander_produits" ).click(function() {
		var commande = {
			    produits: []
			};

		$( "#orderProductsTable tbody tr" ).each(function( index ) {
			var qteProduit = $("#quantite_prod_"+index).val();
		
			var libelle = $(this).find("td:nth-child(1)").html();
			var couleur = $(this).find("td:nth-child(3) select").val();
			commande.produits.push({ 
			        "libelle" : libelle,
			        "qte"  : qteProduit,
			        "couleur"       : couleur 
			    }); 
			
			if( index == $( "#orderProductsTable tbody tr" ).length - 1){
				console.log(commande);
				var arrayContentJson = JSON.stringify(commande);
				$.ajax({
					type: 'POST',
					url: 'https://fast-shore-70377.herokuapp.com/revendeur/mailcommande',
					data: {commande : arrayContentJson},
					success: function(response) {
						if(confirm("Mail de commande envoye !")){

			        		document.location = "https://fast-shore-70377.herokuapp.com/";
			        	}
					},
					error: function(error) {
						console.log(error);
					}
				});
			}
		});
	});
});