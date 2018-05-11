var Drawer = {
	type: 'horizontalBar',
	colorArr: function (length, shade) {
		var colors = [];
		for (i = 0; i < length; i++) {
			colors[i] = 'rgba(' + Math.ceil(Math.random() * 255) + ', ' + Math.ceil(Math.random() * 255) + ',' + Math.ceil(Math.random() * 255) + ', ' + shade + ')';
		}
		return colors;
	},
	randomColor: function (shade) {
		return 'rgba(' + Math.ceil(Math.random() * 255) + ', ' + Math.ceil(Math.random() * 255) + ',' + Math.ceil(Math.random() * 255) + ', ' + shade + ')';
	},
	drawChart: function (ctx, options) {
		return new Chart(ctx, options);
	}
}

var Charts = {
	/*
	 * AJAX fetch the unCall statics and show in chart.
	 */
	resetCanvas: function () {
		$("#canvasDiv").text("");
	},
	visitOverview: function () {
		var startDate = $("#startDate").val(),
			endDate = $("#endDate").val();

		var args = {
			"startDate": startDate,
			"endDate": endDate
		};

		$.post("dingCheck", args, function (data) {
			console.log(data);
			var qcs = [], A = [], B = [], C = [], D = [], total = [], checked = [], uncheck = [], res = JSON.parse(data);
			for (i = 0; i < res.length; i++) {
				qcs[i] = res[i].qc;
				total[i] = res[i].total;
				checked[i] = res[i].checked;
				uncheck[i] = total[i] - checked[i];
				A[i] = checked[i] - res[i].NA;
				B[i] = checked[i] - res[i].NB;
				C[i] = checked[i] - res[i].NC;
				D[i] = checked[i] - res[i].ND;
			}
			var canvasHeight = res.length * 7;
			var rndnum = Math.ceil(Math.random() * 100);
			var canvasID = "newChartCanvas" + rndnum;
			$("#canvasDiv").append("<canvas id='" + canvasID + "' height='" + canvasHeight + "px'></canvas>");
			var ctx = document.getElementById(canvasID).getContext('2d');

			var dr = Drawer;
			var options = {
				type: "horizontalBar",
				data: {
					labels: qcs,
					datasets: [{
						label: "A",
						data: A,
						borderWidth: 1,
						stack: "stack 0",
						backgroundColor: dr.randomColor(0.8),
					}, {
						label: "B",
						data: B,
						borderWidth: 1,
						stack: "stack 0",
						backgroundColor: dr.randomColor(0.8),
					}, {
						label: "C",
						data: C,
						borderWidth: 1,
						stack: "stack 0",
						backgroundColor: dr.randomColor(0.8),
					}, {
						label: "D",
						data: D,
						borderWidth: 1,
						stack: "stack 0",
						backgroundColor: dr.randomColor(0.8),
					}, {
						label: "uncheck",
						data: uncheck,
						borderWidth: 1,
						stack: "stack 0",
						backgroundColor: dr.randomColor(0.8),
					}]
				},
				options: {
					title: {
						display: true,
						text: "Dingcheck overview :" +startDate + " - " + endDate
					},
					scales: {
						yAxes: [{
							beginAtZero: true,
							stacked: true
						}],
						xAxes: [{
							stacked: true

						},]
					}
				}
			};
			dr.drawChart(ctx, options).update();
		});
	},

	/*
	 * AJAX fetch the totalCalled statics and show in bar chart.
	 */
	showCalled: function () {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select batch range first.");
			return;
		};
		var args = {
			"startDate": startDate,
			"endDate": endDate
		}
		$.post("totalcalled", args,
			function (data) {
				var qcs = [], called = [], total = [], uncall = [], unconnected = [], connected = [], connectRate = [], res = JSON.parse(data);
				for (i = 0; i < res.length; i++) {
					qcs[i] = res[i].qc;
					called[i] = res[i].called;
					total[i] = res[i].total;
					uncall[i] = total[i] - called[i];
					unconnected[i] = res[i].unconnected - uncall[i];
					connected[i] = called[i] - unconnected[i];
					connectRate[i] = (connected[i] / (connected[i] + unconnected[i])) * 100;
				}

				var canvasHeight = res.length * 10;

				var rndnum = Math.ceil(Math.random() * 100);
				var canvasID = "newChartCanvas" + rndnum;
				$("#canvasDiv").append("<canvas id='" + canvasID + "' height='" + canvasHeight + "px'></canvas>");
				var ctx = document.getElementById(canvasID).getContext('2d');
				var dr = Drawer;
				var options = {
					type: "horizontalBar",
					data: {
						labels: qcs,
						datasets: [{
							label: "connected",
							data: connected,
							xAxisID: 'x-axis-1',
							borderWidth: 1,
							stack: "stack 0",
							backgroundColor: dr.randomColor(0.8),
						}, {
							label: "unconnected",
							data: unconnected,
							xAxisID: 'x-axis-1',
							borderWidth: 1,
							stack: "stack 0",
							backgroundColor: dr.randomColor(0.8),
						}, {
							label: "uncall",
							data: uncall,
							xAxisID: 'x-axis-1',
							borderWidth: 1,
							stack: "stack 0",
							backgroundColor: dr.randomColor(0.8),
						}, {
							label: "connectRate%",
							data: connectRate,
							xAxisID: 'x-axis-2',
							borderWidth: 1,
							stack: "stack 1",
							backgroundColor: dr.randomColor(0.8),
						}]
					},
					options: {
						title: {
							display: true,
							text: "call volumn overview:" + startDate + " - " + endDate
						},
						scales: {
							xAxes: [{
								stacked: true,
								beginAtZero: true,
								type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
								display: true,
								position: 'bottom',
								id: 'x-axis-1',
								scaleLabel: {
									display: true,
									labelString: 'Volume'
								},
							}, {
								type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
								display: true,
								position: 'top',
								id: 'x-axis-2',
								scaleLabel: {
									display: true,
									labelString: 'Percentage'
								},
								gridLines: {
									drawOnChartArea: false
								}
							}],
							yAxes: [{
								stacked: true

							},]
						}
					}
				};
				dr.drawChart(ctx, options).update();
			});
	}

}
