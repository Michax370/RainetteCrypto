$( document ).ready(function() {
	$.ajax({
        type: 'GET',
        url: 'https://fast-shore-70377.herokuapp.com/revendeur/stats',
		contentType: "application/text",
		dataType: "text",
        success: function(response) {
        	stats = JSON.parse(response);
        	var i = 0;
        	$.each( stats["revendeur"][0], function( index, value ){
            		$('#stats tbody').append('<tr><td>'+value['nom']+'</td><td>'+value['zoneGeo']+'</td><td>'+value['ca']+' \u20ac</td><td>'+stats["revendeur"][1][i]["produit"]+'</td></tr>');
            		i++;
        	});
        	$("#stats").tablesorter(); 
            
        },
        error: function(error) {
            console.log(error);
        }
    });
	// tableau des revendeurs général
	$( "#revendeurs_general" ).click(function() {
		$.ajax({
	        type: 'GET',
	        url: 'https://fast-shore-70377.herokuapp.com/revendeur/stats',
			contentType: "application/text",
			dataType: "text",
	        success: function(response) {
	        	stats = JSON.parse(response);
	        	var i = 0;
	        	// on clear le tableau
	        	$("#stats").find("tr:gt(0)").remove();
	        	$.each( stats["revendeur"][0], function( index, value ){
            		$('#stats tbody').append('<tr><td>'+value['nom']+'</td><td>'+value['zoneGeo']+'</td><td>'+value['ca']+' \u20ac</td><td>'+stats["revendeur"][1][i]["produit"]+'</td></tr>');
            		i++;
	        	});
	        	var resort = true;
	            $("#stats").trigger("update", [resort]);
	        },
	        error: function(error) {
	            console.log(error);
	        }
	    });
	});
	// tableau des revendeurs physiques
	$( "#revendeurs_phy" ).click(function() {
		$.ajax({
	        type: 'GET',
	        url: 'https://fast-shore-70377.herokuapp.com/revendeur/stats/physique',
			contentType: "application/text",
			dataType: "text",
	        success: function(response) {
	        	stats = JSON.parse(response);
	        	var i = 0;
	        	// on clear le tableau
	        	$("#stats").find("tr:gt(0)").remove();
	        	$.each( stats["revendeur"][0], function( index, value ){
            		$('#stats tbody').append('<tr><td>'+value['nom']+'</td><td>'+value['zoneGeo']+'</td><td>'+value['ca']+' \u20ac</td><td>'+stats["revendeur"][1][i]["produit"]+'</td></tr>');
            		i++;
	        	});
	        	var resort = true;
	            $("#stats").trigger("update", [resort]);
	        	
	        },
	        error: function(error) {
	            console.log(error);
	        }
	    });
	});
	
	// tableau des revendeurs web
	$( "#revendeurs_web" ).click(function() {
		$.ajax({
	        type: 'GET',
	        url: 'https://fast-shore-70377.herokuapp.com/revendeur/stats/web',
			contentType: "application/text",
			dataType: "text",
	        success: function(response) {
	        	stats = JSON.parse(response);
	        	var i = 0;
	        	// on clear le tableau
	        	$("#stats").find("tr:gt(0)").remove();
	        	$.each( stats["revendeur"][0], function( index, value ){
            		$('#stats tbody').append('<tr><td>'+value['nom']+'</td><td>'+value['zoneGeo']+'</td><td>'+value['ca']+' \u20ac</td><td>'+stats["revendeur"][1][i]["produit"]+'</td></tr>');
            		i++;
	        	});
	        	var resort = true;
	            $("#stats").trigger("update", [resort]);
	        	
	        },
	        error: function(error) {
	            console.log(error);
	        }
	    });
	});
});