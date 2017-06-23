$( document ).ready(function() {
	var login = $('#current_login').val();
	$.ajax({
        type: 'GET',
        url: 'https://fast-shore-70377.herokuapp.com/revendeur/'+login,
		contentType: "application/text",
		dataType: "text",
        success: function(response) {
			info = JSON.parse(response);
			$('#nom').val(info["revendeur"][0]["nom"]);
			$('#prenom').val(info["revendeur"][0]["prenom"]);
			$('#ville').val(info["revendeur"][0]["ville"]);
			$('#cp').val(info["revendeur"][0]["cp"]);
			$('#rue').val(info["revendeur"][0]["rue"]);
			$('#num_rue').val(info["revendeur"][0]["numRue"]);
			$('#num_tel').val(info["revendeur"][0]["telephone"]);
			
		},
        error: function(error) {
            console.log(error);
        }
    });
});