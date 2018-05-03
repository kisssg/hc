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
	drawChart: function (ctx, title, label, labels, data) {
		return new Chart(ctx, {
			type: this.type,
			data: {
				labels: labels,
				datasets: [{
					label: label,
					data: data,
					borderWidth: 1,
					backgroundColor: this.randomColor(0.8),
					borderColor: this.randomColor(0.9)

				}]
			},
			options: {
				title: {
					display: true,
					text: title
				}
			}
		})
	}
}

var Charts = {
	/*
	 * AJAX fetch the unCall statics and show in bar chart.
	 */
	showUncall: function () {
		$.post("uncall", "", function (data) {
			var qcs = [], counts = [], res = JSON.parse(data);
			for (i = 0; i < res.length; i++) {
				qcs[i] = res[i].qc;
				counts[i] = res[i].count;
			}
			var ctx = document.getElementById("chartCanvas").getContext('2d');
			ctx.restore();
			ctx.clearRect(0, 0,ctx.canvas.width, ctx.canvas.height);
			Drawer.drawChart(ctx, "Uncall counts in hand", "uncall", qcs,counts).update();
		});
	},

	/*
	 * AJAX fetch the totalCalled statics and show in bar chart.
	 */
	showCalled: function () {
		$.post("totalcalled", "",
			function (data) {
				var qcs = [], counts = [], counts1 = [], res = JSON.parse(data);
				for (i = 0; i < res.length; i++) {
					qcs[i] = res[i].qc;
					counts[i] = res[i].called;
					//counts1[i] = res[i].uncall;
				}
				var ctx = document.getElementById("chartCanvas").getContext('2d');
				ctx.restore();
				var dr = Drawer;
				dr.type = 'horizontalBar';
				dr.drawChart(ctx, "Total called count", "called", qcs,counts).update();
			});
	}
}
