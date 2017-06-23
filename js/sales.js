
google.load('visualization', '1', {'packages':['corechart']});
//TODO Faire avec les bouttons pour chaque produit et pour les différent types de courbes avec analyse de courbes
function drawChart(typeGraph = 'courbe') {

	if(typeGraph == 'courbe' || typeGraph == 'barres'){
		//appel ajax afin de récuperer les ventes
		$.ajax({
			type: 'GET',
			url: 'https://fast-shore-70377.herokuapp.com/sales/all',
			contentType: "application/text",
			dataType: "text",
			success: function(response) {
				var dataFromBdd  = JSON.parse(response);
				var arrayToChart =[]
				// on place les ventes (date, qte) dans un tableau
				for(i=0; i<dataFromBdd.length;i++){
					var array = $.map(dataFromBdd[i], function(value, index) {
						if(index == 'quantite'){
							return parseInt([value]);
						}
						else{
							return new Date([value]);
						}
					});
					arrayToChart.push(array);
				}

				// on met le tableau dans le dataTable
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Date');
				data.addColumn('number', 'quantite vendue');
				data.addRows(arrayToChart);
				var dateMax;
				var dateMin;

				// On recupere les val max et min des qtes vendues
				var maxQte = data.getColumnRange(1).max;
				var minQte = data.getColumnRange(1).min;

				// On recupere les dates a laquelle les min et max de ventes on été réalisées
				$(data.Nf).each(function( index, value ) {
					if(value.c[1].v == maxQte){
						dateMax = value.c[0].v;
					}	
					if(value.c[1].v == minQte){
						dateMin = value.c[0].v;
					}
				})

				// Conversion des dates pour etre au format dd/mm/yyyy
				dateMaxIso = dateMax.toISOString().split("T")[0];
				dateMaxTab = dateMaxIso.split("-");
				dateMaxFormated = dateMaxTab[2]+'/'+dateMaxTab[1]+'/'+dateMaxTab[0];

				dateMinIso = dateMin.toISOString().split("T")[0];
				dateMinTab = dateMinIso.split("-");
				dateMinFormated = dateMinTab[2]+'/'+dateMinTab[1]+'/'+dateMinTab[0];

				$('#analyseVentes').html('Nombre de ventes maximale: '+maxQte+' le '+dateMaxFormated+'<br> Nombre de ventes minimales: '+minQte+' le '+dateMinFormated);

				//Graphe courbe
				if(typeGraph == 'courbe'){
					var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
					chart.draw(data, {width: 800, height: 400});
				}
				//Graphe en barres
				if(typeGraph == 'barres'){
					var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
					chart.draw(data, {width: 800, height: 400});
				}
				//Graphe circulaire
				if(typeGraph == 'circulaire'){
					var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
					chart.draw(data, {width: 800, height: 400});
				}


			},
			error: function(error) {
				console.log(error);
			}
		});
	}
	else{
		$('#analyseVentes').html('');
		//appel ajax afin de récuperer les ventes
		$.ajax({
			type: 'GET',
			url: 'https://fast-shore-70377.herokuapp.com/sales/quantite',
			contentType: "application/text",
			dataType: "text",
			success: function(response) {
				console.log(response);
				var dataFromBdd  = JSON.parse(response);
				var arrayToChart =[]
				// on place les ventes (date, qte) dans un tableau
				for(i=0; i<dataFromBdd.length;i++){
					var array = $.map(dataFromBdd[i], function(value, index) {
						if(index == 'qte'){
							return parseInt([value]);
						}
						else{
							return [value];
						}
					});
					arrayToChart.push(array);
				}
				
				console.log(arrayToChart);
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Produit');
				data.addColumn('number', 'quantite');
				data.addRows(arrayToChart);
			
				var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				chart.draw(data, {width: 800, height: 400});
			},
			error: function(error) {
				console.log(error);
			}
		});
	}
}


google.setOnLoadCallback(function() {
	drawChart();
});





$( document ).ready(function() {

	$( "#courbe" ).click(function() {
		drawChart();
	});
	$( "#circular_graph" ).click(function() {
		drawChart("circulaire");
	});
	$( "#bar_graph" ).click(function() {
		drawChart("barres");
	});
	// appel ajax pour récupérer les produits afin de remplir le select
	$.ajax({
		type: 'GET',
		url: 'https://fast-shore-70377.herokuapp.com/product/all',
		contentType: "application/text",
		dataType: "text",
		success: function(response) {
			products = JSON.parse(response);
			$.each( products, function( index, value ){
				$('#selectProduct').append($("<option></option>")
						.attr("value",value['libelle'])
						.text(value['libelle'])); 
			});

		},
		error: function(error) {
			console.log(error);
		}
	});
});