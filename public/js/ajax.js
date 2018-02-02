var SignUp = {
	name : "SignUp",
	description : "",
	check : function(id) {
		if ($.trim($("#" + id)[0].value) == '') {
			$("#" + id)[0].focus();
			return false;
		}
		;

		return true;
	},
	validate : function() {
		if (SignUp.check("name") == false) {
			return false;
		}
		if (SignUp.check("email") == false) {
			return false;
		}
	},
	submit : function() {
		if (SignUp.validate() == false) {
			return false;
		}
		url = "signup/register";
		name = $("#name")[0].value;
		email = $("#email")[0].value;
		args = {
			"name" : name,
			"email" : email
		}
		$.post(url, args, function(data) {
			re = JSON.parse(data);
			if (re.result == "success") {
				window.location.href = "signin";
			} else {
				alert(re.result);
			}
		})
	}
}
var SignIn = {
	login : function() {
		alert(0);
	}
}

var Drawer = {
	type : "bar",
	drawChart : function(ctx, title, label, labels, data) {
		return new Chart(ctx, {
			type : this.type,
			data : {
				labels : labels,
				datasets : [ {
					label : label,
					data : data,
					borderWidth : 1
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
				}
			}
		})
	}
}

$(document).ready(
		function() {
			/*
			 * AJAX fetch the unCall statics and show in bar chart.
			 */
			$.post("charts/uncall", "", function(data) {
				var qcs = [], counts = [];
				res = JSON.parse(data);
				for (i = 0; i < res.length; i++) {
					qcs[i] = res[i].qc;
					counts[i] = res[i].count;
				}
				var ctx = document.getElementById("uncall").getContext('2d');
				Drawer.drawChart(ctx,"Uncall counts in hand","uncall",qcs,counts);

			})

			/*
			 * AJAX fetch the totalCalled statics and show in bar chart.
			 */
			$.post("charts/totalcalled", "", function(data) {
				var qcs = [], counts = [];
				res = JSON.parse(data);
				for (i = 0; i < res.length; i++) {
					qcs[i] = res[i].qc;
					counts[i] = res[i].count;
				}
				var ctx = $("#totalcalled");
				var dr=Drawer;
				dr.type="bar";
				dr.drawChart(ctx,"Total called count", "totalcalled", qcs, counts);
			})
		})
