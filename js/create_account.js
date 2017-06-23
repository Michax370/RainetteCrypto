$( document ).ready(function() {
	$("#cp").click(function() {
			var ville = $("#ville").val();
			var lng = 0.0;
			var lat = 0.0;
			$.ajax({
				type: 'GET',
				url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+ville+'&key=AIzaSyBo2QQPBHBWBORSALUrmJmdyNb9bb0vKKs',
				
				success: function(response) {
					lng = response.results[0].geometry.location.lng;
					lat = response.results[0].geometry.location.lat;
					$("#lng").val(lng);
					$("#lat").val(lat);

				},
				error: function(error) {
					console.log(error);
				}
			});
	});
	
  $("#createAccountForm").submit(function (e) {
		
	    var password = $("#password").val();
		var passConfirm = $("#passconfirm").val();
		if(password != passConfirm){
			alert("Les deux mots de passe ne correspondent pas !");
			return false;
		}
	});
});