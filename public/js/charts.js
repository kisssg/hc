var Drawer = {
	type : 'horizontalBar',	
	colorArr:function(length,shade){
		var colors=[];
		for(i=0;i<length;i++){
			colors[i]='rgba('+Math.ceil(Math.random()*255) +', '+Math.ceil(Math.random()*255) +','+Math.ceil(Math.random()*255) +', '+shade+')';
		}
		return colors;
	},
	drawChart : function(ctx, title, label, labels, data) {		
		return new Chart(ctx, {
			type : this.type,
			data : {
				labels : labels,
				datasets : [ {
					label : label,
					data : data,
					borderWidth : 1,
					backgroundColor:this.colorArr(data.length,0.3),
					borderColor:this.colorArr(data.length,0.6)

				} ]
			},
			options : {
				title : {
					display : true,
					text : title
				},
				scales : {
					yAxes : [ {
						ticks : {
							beginAtZero : true
						}
					} ]
				},
			}
		})
	}
}

var Charts = {
	/*
	 * AJAX fetch the unCall statics and show in bar chart.
	 */
	showUncall : function() {
		$.post("uncall", "", function(data) {
			var qcs = [], counts = [], res = JSON.parse(data);
			for (i = 0; i < res.length; i++) {
				qcs[i] = res[i].qc;
				counts[i] = res[i].count;
			}
			var ctx = document.getElementById("uncall").getContext('2d');
			Drawer.drawChart(ctx, "Uncall counts in hand", "uncall", qcs,
					counts);

		});
	},

	/*
	 * AJAX fetch the totalCalled statics and show in bar chart.
	 */
	showCalled : function() {
		$.post("totalcalled", "",
				function(data) {
					var qcs = [], counts = [], res = JSON.parse(data);
					for (i = 0; i < res.length; i++) {
						qcs[i] = res[i].qc;
						counts[i] = res[i].count;
					}
					var ctx = $("#totalcalled");
					var dr = Drawer;
					dr.type = 'horizontalBar';
					dr.drawChart(ctx, "Total called count", "totalcalled", qcs,
							counts);
				});
	}
}
