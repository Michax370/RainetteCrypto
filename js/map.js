
//appeler les urls de service qui recup les revendeurs
function myMap() {

	var coordonnees = null;
	 $.ajax({
            type: 'GET',
            url: 'https://fast-shore-70377.herokuapp.com/map/revendeurs',
			contentType: "application/text",
			dataType: "text",
            success: function(response) {
				coordonnees = JSON.parse(response);
				
				posParis = {"lat" : 48.866667, "lng" : 2.333333};
				var map = new google.maps.Map(document.getElementById('googleMap'), {
				zoom: 12,
				center: posParis
				});
			  
				$.each( coordonnees["revendeur"], function( index, value ){
					
					// on recuperere les coordonnées de chaque revendeur et on place les points
					pos = {"lat" : parseFloat(value['coordonneesX']),"lng" : parseFloat(value['coordonneesY'])};
					
					//description lors du click sur le point
					var contentString = '<div id="content">'+
				  '<div id="siteNotice">'+
				  '</div>'+
				  '<h2 id="firstHeading" class="firstHeading">'+value['nom']+' '+value['prenom']+'</h2>'+
				  '<div id="bodyContent">'+
				  '<p>'+value['numRue']+' '+value['rue']+'<br>'+value['cp']+' '
					+value['ville']+'<br> Tel: '+value['telephone']+'</p>'+
				  '<p><a href="https://fast-shore-70377.herokuapp.com/views/info_revendeur.php?id='+value['id']+'">'+
				  'Voir les ventes et stocks</a></p>'+
				  '</div>'+
				  '</div>';

				  var infowindow = new google.maps.InfoWindow({
					content: contentString
				  });

				  var marker = new google.maps.Marker({
					position: pos,
					map: map
				  });
				  
				  
				  marker.addListener('click', function() {
					infowindow.open(map, marker);
				  });
				  
				});
            },
            error: function(error) {
                console.log(error);
            }
        });

  
}