var Drawer = {
	type : 'horizontalBar',
	colorArr : function(length, shade) {
		var colors = [];
		for (i = 0; i < length; i++) {
			colors[i] = 'rgba(' + Math.ceil(Math.random() * 255) + ', '
					+ Math.ceil(Math.random() * 255) + ','
					+ Math.ceil(Math.random() * 255) + ', ' + shade + ')';
		}
		return colors;
	},
	randomColor : function(shade) {
		return 'rgba(' + Math.ceil(Math.random() * 255) + ', '
				+ Math.ceil(Math.random() * 255) + ','
				+ Math.ceil(Math.random() * 255) + ', ' + shade + ')';
	},
	drawChart : function(ctx, options) {
		return new Chart(ctx, options);
	}
}

var Charts = {
	/*
	 * AJAX fetch the unCall statics and show in chart.
	 */
	resetCanvas : function() {
		$("#canvasDiv").text("");
	},
	visitOverview : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select range first.");
			return;
		}
		;

		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		};

		$
				.post(
						"dingCheck",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("无可显示数据！");
								return;
							}
							console.log(data);
							var qcs = [], A = [], B = [], C = [], D = [], total = [], checked = [], uncheck = [], res = JSON
									.parse(data);
							for (i = 0; i < res.length; i++) {
								qcs[i] = res[i].qc;
								total[i] = res[i].total;
								checked[i] = res[i].checked;
								uncheck[i] = total[i] - checked[i];
								A[i] = total[i] - res[i].NA;
								B[i] = total[i] - res[i].NB;
								C[i] = total[i] - res[i].NC;
								D[i] = total[i] - res[i].ND;
							}
							var canvasHeight = (res.length+1) * 7;
							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');

							var dr = Drawer;
							var options = {
								type : "horizontalBar",
								data : {
									labels : qcs,
									datasets : [ {
										label : "A",
										data : A,
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "B",
										data : B,
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "C",
										data : C,
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "D",
										data : D,
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "uncheck",
										data : uncheck,
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									} ]
								},
								options : {
									title : {
										display : true,
										text : "Dingcheck overview :"
												+ startDate + " - " + endDate
									},
									scales : {
										yAxes : [ {
											beginAtZero : true,
											stacked : true
										} ],
										xAxes : [ {
											stacked : true

										}, ]
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	},

	/*
	 * AJAX fetch the totalCalled statics and show in bar chart.
	 */
	batchOverview : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select batch range first.");
			return;
		}
		;
		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		}
		$
				.post(
						"totalcalled",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("无可显示数据！");
								return;
							}
							var qcs = [], called = [], total = [], uncall = [], unconnected = [], connected = [], connectRate = [], res = JSON
									.parse(data);
							for (i = 0; i < res.length; i++) {
								qcs[i] = res[i].qc;
								called[i] = res[i].called;
								total[i] = res[i].total;
								uncall[i] = total[i] - called[i];
								unconnected[i] = res[i].unconnected - uncall[i];
								connected[i] = called[i] - unconnected[i];
								connectRate[i] = (connected[i] / (connected[i] + unconnected[i])) * 100;
							}

							var canvasHeight = (res.length+1) * 10;

							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');
							var dr = Drawer;
							var options = {
								type : "horizontalBar",
								data : {
									labels : qcs,
									datasets : [ {
										label : "connected",
										data : connected,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "unconnected",
										data : unconnected,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "uncall",
										data : uncall,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "connectRate%",
										data : connectRate,
										xAxisID : 'x-axis-2',
										borderWidth : 1,
										stack : "stack 1",
										backgroundColor : dr.randomColor(0.8),
									} ]
								},
								options : {
									title : {
										display : true,
										text : "call volumn overview:"
												+ startDate + " - " + endDate
									},
									scales : {
										xAxes : [ {
											stacked : true,
											beginAtZero : true,
											type : 'linear', // only linear
																// but allow
																// scale type
																// registration.
																// This allows
																// extensions to
																// exist solely
																// for log scale
																// for instance
											display : true,
											position : 'bottom',
											id : 'x-axis-1',
											scaleLabel : {
												display : true,
												labelString : 'Volume'
											},
										}, {
											type : 'linear', // only linear
																// but allow
																// scale type
																// registration.
																// This allows
																// extensions to
																// exist solely
																// for log scale
																// for instance
											display : true,
											position : 'top',
											id : 'x-axis-2',
											scaleLabel : {
												display : true,
												labelString : 'Percentage'
											},
											gridLines : {
												drawOnChartArea : false
											}
										} ],
										yAxes : [ {
											stacked : true

										}, ]
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	},
	showHarass : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select range first.");
			return;
		}
		;
		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		}
		$
				.post(
						"harassRecieved",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("无可显示数据！");
								return;
							}
							var qcs = [], total = [], noharass = [], harass = [], rate = [], res = JSON
									.parse(data);
							for (i = 0; i < res.length; i++) {
								qcs[i] = res[i].qc;
								total[i] = res[i].total;
								noharass[i] = res[i].noharass;
								harass[i] = total[i] - noharass[i];
								rate[i] = harass[i] / total[i];
							}

							var canvasHeight = (res.length+1) * 10;

							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');
							var dr = Drawer;
							var options = {
								type : "horizontalBar",
								data : {
									labels : qcs,
									datasets : [ {
										label : "cnt_harass",
										data : harass,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "cnt_normal",
										data : noharass,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									}, {
										label : "HarassRecieve%",
										data : rate,
										xAxisID : 'x-axis-2',
										borderWidth : 1,
										stack : "stack 1",
										backgroundColor : dr.randomColor(0.8),
									} ]
								},
								options : {
									title : {
										display : true,
										text : "Harass recieved overview:"
												+ startDate + " - " + endDate
									},
									scales : {
										xAxes : [ {
											stacked : true,
											beginAtZero : true,
											type : 'linear', // only linear
																// but allow
																// scale type
																// registration.
																// This allows
																// extensions to
																// exist solely
																// for log scale
																// for instance
											display : true,
											position : 'bottom',
											id : 'x-axis-1',
											scaleLabel : {
												display : true,
												labelString : 'Volume'
											},
										}, {
											type : 'linear', // only linear
																// but allow
																// scale type
																// registration.
																// This allows
																// extensions to
																// exist solely
																// for log scale
																// for instance
											display : true,
											position : 'top',
											id : 'x-axis-2',
											scaleLabel : {
												display : true,
												labelString : 'Percentage'
											},
											gridLines : {
												drawOnChartArea : false
											}
										} ],
										yAxes : [ {
											stacked : true

										}, ]
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	},
	issueTypeOverview : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select range first.");
			return;
		}
		;
		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		};
		$
				.post(
						"issueType",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("No data to show.");
								return;
							}
							var types = [], counts = [], res = JSON.parse(data);
							for (i = 0; i < res.length; i++) {
								types[i] = res[i].type;
								counts[i] = res[i].count;
							}

							var canvasHeight = (res.length+1)*7;

							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');
							var dr = Drawer;
							var options = {
								type : 'horizontalBar',
								data : {
									labels : types,
									datasets : [ {
										label : "counts",
										data : counts,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										backgroundColor : dr.randomColor(1)
									} ]
								},
								options : {
									title : {
										display : true,
										text : "Issues overview(valid and under investigation):"
												+ startDate + " - " + endDate
									},
									scales : {
										xAxes : [ {
											stacked : true,
											beginAtZero : true,
											type : 'linear', 
											display : true,
											position : 'bottom',
											id : 'x-axis-1',
											scaleLabel : {
												display : false,
												labelString : 'Volume'
											},
										} ],
										yAxes : [ {
											stacked : true

										}, ]
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	},
	harassTypeOverview : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select range first.");
			return;
		}
		;
		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		};
		$
				.post(
						"harassmentType",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("No data to show.");
								return;
							}
							var types = [], counts = [], res = JSON.parse(data);
							for (i = 0; i < res.length; i++) {
								types[i] = res[i].type;
								counts[i] = res[i].count;
							}

							var canvasHeight = "220";

							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');
							var dr = Drawer;
							var options = {
								type : 'doughnut',
								data : {
									labels : types,
									datasets : [ {
										label : "counts",
										data : counts,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.colorArr(
												res.length, 1),
									} ]
								},
								options : {
									title : {
										display : true,
										text : "Harassment type overview(valid and under investigation):"
												+ startDate + " - " + endDate
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	},
	issueQCOverview : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select range first.");
			return;
		}
		;
		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		};
		$
				.post(
						"issueQCOverview",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("No data to show.");
								return;
							}
							var types = [], counts = [], res = JSON.parse(data);
							for (i = 0; i < res.length; i++) {
								types[i] = res[i].type;
								counts[i] = res[i].count;
							}

							var canvasHeight = (res.length+1)*7;

							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');
							var dr = Drawer;
							var options = {
								type : 'horizontalBar',
								data : {
									labels : types,
									datasets : [ {
										label : "counts",
										data : counts,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									} ]
								},
								options : {
									title : {
										display : true,
										text : "Harassment type overview(valid and under investigation):"
												+ startDate + " - " + endDate
									},
									scales : {
										xAxes : [ {
											stacked : true,
											beginAtZero : true,
											type : 'linear', 
											display : true,
											position : 'bottom',
											id : 'x-axis-1',
											scaleLabel : {
												display : false,
												labelString : 'Volume'
											},
										} ],
										yAxes : [ {
											stacked : true

										}, ]
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	},
	avgSecCost : function() {
		var startDate = $("#startDate").val(), endDate = $("#endDate").val();
		if (startDate == "" || endDate == "") {
			alert("Select range first.");
			return;
		}
		;
		var args = {
			"startDate" : startDate,
			"endDate" : endDate
		};
		$.post(
						"checkEfficiency",
						args,
						function(data) {
							if (data == '[]') {// no data.
								alert("No data to show.");
								return;
							}
							var qv=[],bunch = [] , res = JSON.parse(data);		
							
							for (i = 0,k=0; i < res.length; i++) {								
								bunch[k]=new Object;
								bunch[k].qc=res[i].qc.toLowerCase();
								if(res[i].validity=="A"){
									bunch[k].a=res[i].avgSecCost;										
								}
								console.log(bunch[k].qc);
								for(j=i+1;j<res.length;j++,i++){
									if(res[i].qc.toLowerCase()!=res[j].qc.toLowerCase()){
										break;
									}
									if(res[j].qc.toLowerCase()==bunch[k].qc && res[j].validity=="B"){
										bunch[k].b=res[j].avgSecCost;										
									}
									if(res[j].qc.toLowerCase()==bunch[k].qc && res[j].validity=="C"){
										bunch[k].c=res[j].avgSecCost;										
									}
									if(res[j].qc.toLowerCase()==bunch[k].qc && res[j].validity=="D"){
										bunch[k].d=res[j].avgSecCost;										
									}
								}								
								k++;
							}//rearrange the data to make a object array of qc's abcd avgSecCost
							//split the object array into 5 individual arrays(qc,a,b,c,d)
							
							var qcs=[],a=[],b=[],c=[],d=[];
							for (i=0;i<bunch.length;i++){
								qcs[i]=bunch[i].qc;
								a[i]=bunch[i].a;
								b[i]=bunch[i].b;
								c[i]=bunch[i].c;
								d[i]=bunch[i].d;								
							}
							
							var canvasHeight = (res.length+1) * 7;
							var rndnum = Math.ceil(Math.random() * 100);
							var canvasID = "newChartCanvas" + rndnum;
							$("#canvasDiv").append(
									"<canvas id='" + canvasID + "' height='"
											+ canvasHeight + "px'></canvas>");
							var ctx = document.getElementById(canvasID)
									.getContext('2d');
							var dr = Drawer;
							var options = {
								type : 'horizontalBar',
								data : {
									labels : qcs,
									datasets : [ {
										label : "A avgSecCost",
										data : a,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 0",
										backgroundColor : dr.randomColor(0.8),
									} ,{
										label : "B avgSecCost",
										data : b,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 1",
										backgroundColor : dr.randomColor(0.8),
									},{
										label : "C avgSecCost",
										data : c,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 2",
										backgroundColor : dr.randomColor(0.8),
									},{
										label : "D avgSecCost",
										data : d,
										xAxisID : 'x-axis-1',
										borderWidth : 1,
										stack : "stack 3",
										backgroundColor : dr.randomColor(0.8),
									}]
								},
								options : {
									title : {
										display : true,
										text : "AvgSecCost per check:"
												+ startDate + " - " + endDate
									},
									scales : {
										xAxes : [ {
											stacked : true,
											beginAtZero : true,
											type : 'linear', 
											display : true,
											position : 'bottom',
											id : 'x-axis-1',
											scaleLabel : {
												display : false,
												labelString : 'Volume'
											},
										} ],
										yAxes : [ {
											stacked : true

										}, ]
									}
								}
							};
							dr.drawChart(ctx, options).update();
							scrollHeight = document.body.offsetHeight
									- canvasHeight;
							window.scrollTo(0, scrollHeight);
						});
	}
}
