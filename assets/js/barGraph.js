$(function(){
	barGraph();
});

function barGraph()
{
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
				alert(result);
				Morris.Bar({
					element: 'graph',
					data: [
						{ region: result.region, 	value: result.value }
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