var regions = ['I', 'II', 'III', 'CALABARZON', 'MIMAROPA', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'CARAGA', 'CAR', 'BARMM', 'NCR'];
$(function(){
	encodedGraph();
	reachedGraph();
	methodGraph();
	wraGraph();
	unmetservedGraph();
});

function encodedGraph()
{
	// var graph1 = document.getElementById('barGraph1');	
	// var myBarChart = new Chart(graph1, {
	// 	type: 'bar',
	// 	data: {
	// 		labels: regions,
	// 		datasets: [{
	// 			label: 'Encoded vs Target',
	// 			data: [100, 73, 58, 46, 36, 37, 57, 60, 63, 66, 68, 82, 67, 55, 44, 34, 41],
	// 			backgroundColor: '#62A0DB'
	// 		}, {
	// 			label: 'Encoded vs Reached',
	// 			data: [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100],
	// 			backgroundColor: '#F27724'
	// 		}, {
	// 			label: 'Target vs Reached',
	// 			data: [90, 73, 58, 46, 36, 37, 57, 60, 63, 66, 68, 82, 67, 55, 44, 34, 41],
	// 			backgroundColor: '#AEAEAE'
	// 		}],			
	// 	},
	// });

	$('select[id="percentage_year"]').change(function(){
		var percentageYear = $(this).val();

		$.ajax({
			url: base_url + '/menu/barGraph',
			method: "POST",
			data: {
				percentage_year: percentageYear
			},
			dataType: "json",
			success: function(result) {
				console.log(result);
				Morris.Bar({
					element: 'graph',
					data: [
						{ region: result.EncodedTarget, 	value: result.davalue }
						// { region: 'R2', 	value: 55.73 },
						// { region: 'R3', 	value: 69.8 },
						// { region: 'R4A', 	value: 14.91 },
						// { region: 'R4B', 	value: 5.19 },
						// { region: 'R5', 	value: 24.81 },
						// { region: 'R6', 	value: 16.45 },
						// { region: 'R7', 	value: 35.66 },
						// { region: 'R8', 	value: 44.56 },
						// { region: 'R9', 	value: 56.95 },
						// { region: 'R10', 	value: 40.48 },
						// { region: 'R11', 	value: 11.08 },
						// { region: 'R12', 	value: 51.43 },
						// { region: 'ARMM', 	value: 19.69 },
						// { region: 'CAR', 	value: 49.12 },
						// { region: 'CARAGA', value: 28.17 },
						// { region: 'NCR', 	value: 42.48 }
					],
					xkey: 'region',
					ykeys: ['value'],
					labels: ['value'],
					barColors: ['#095017'],
					xLabelMargin: 10
				});
			}
		})
	})
}

function reachedGraph()
{
	var graph2 = document.getElementById('barGraph2');	
	var myBarChart = new Chart(graph2, {
		type: 'bar',
		data: {
			labels: regions,
			datasets: [{
				label: 'Couples',
				data: [750, 670, 590, 510, 430, 445, 510, 630, 750, 870, 990, 786, 706, 636, 536, 466, 326],
				backgroundColor: '#62A0DB'
			}, {
				label: 'Male Only',
				data: [50, 40, 30, 20, 10, 55, 45, 35, 25, 15, 5, 42, 32, 12, 22, 2, 52],
				backgroundColor: '#F27724'
			}, {
				label: 'Female Only',
				data: [100, 90, 80, 70, 60, 50, 95, 85, 75, 65, 55, 92, 82, 72, 62, 52, 42],
				backgroundColor: '#AEAEAE'
			}],			
		},
	});
}

function methodGraph()
{
	var pie1 = document.getElementById('pieChart1');
	var methods = ['Condom', 'IUD', 'Pills', 'Injectible', 'Vasectomy', 'Tubal Ligation', 'Implant', 'CMM/Billings', 'BBT', 'Sympto-Thermal', 'SDM', 'LAM', 'Traditional Methods', 'No Method'];
	var methodColors = ['#67a2d8', '#ef8943', '#b3b3b3', '#ffd24b', '#6e92d1', '#84ba60', '#5c98cf', '#eb8642', '#9e9e9e', '#f6c225', '#3a5b96', '#547d39', '#a0c5e7','#F29D63'];
	
	var myPieChart = new Chart(pie1, {
		type: 'pie',
		data: {
			labels: methods,
			datasets: [{
				label: 'Couples',
				data: [750, 670, 590, 510, 430, 445, 510, 630, 750, 870, 990, 786, 706, 636],
				backgroundColor: methodColors
			}],			
		},
		options: {
			legend: {
				display: true,
				position: 'right',
			}
		}
	});
}


function wraGraph()
{
	var graph3 = document.getElementById('barGraph3');
	var ageGroups = ['60 above', '56-60', '51-55', '46-50', '41-45', '36-40', '31-35', '26-30', '21-25',  '15-20'];

	var myBarChart = new Chart(graph3, {
		type: 'horizontalBar',
		data: {
			labels: ageGroups,
			datasets: [{
				data: [11, 15, 13, 16, 15, 4, 5, 6, 7, 8],
				backgroundColor: '#62A0DB'
			}],			
		},
		options: {
			legend: {
				display: false
			}
		}
	});
}

function unmetservedGraph()
{
	var graph4 = document.getElementById('barGraph4');		
	var myBarChart = new Chart(graph4, {
		type: 'bar',
		data: {
			labels: regions,
			datasets: [{
				label: 'Unmet Need',
				data: [500, 420, 340, 260, 180, 195, 250, 380, 500, 620, 740, 536, 456, 386, 286, 216, 176],
				backgroundColor: '#62A0DB'
			}, {
				label: 'Served',
				data: [150, 130, 110, 90, 70, 105, 140, 120, 100, 80, 60, 134, 114, 84, 84, 54, 94],
				backgroundColor: '#F27724'
			}],			
		},
	});

}