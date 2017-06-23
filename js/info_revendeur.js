function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}

var id = $_GET('id');
$.ajax({
            type: 'GET',
            url: 'https://fast-shore-70377.herokuapp.com/revendeur/'+id,
			contentType: "application/text",
			dataType: "text",
            success: function(response) {
				info = JSON.parse(response);
				
				$('#stockProduitA').text("Stock produit A : "+info["revendeur"][0]["stockProduitA"]);
				$('#stockProduitB').text("Stock produit B : "+info["revendeur"][0]["stockProduitB"]);
			},
            error: function(error) {
                console.log(error);
            }
        });