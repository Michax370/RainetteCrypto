$( document ).ready(function() {
	$("#form_stock_entry").submit(function (e) {
		
		var stockProduitA = $("#stockProduitA").val();
		var stockProduitB = $("#stockProduitB").val();
		if(isNaN(stockProduitA)|| isNaN(stockProduitB)){
			alert("Veuillez saisir des chiffres !");
			return false;
		}
	});
});
