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
/*
 * AJAX fetch the uncalled statics.
 */
$.post("charts/uncalled", "", function(data) {
	var qcs = [], counts = [];
	res = JSON.parse(data);
	for (i = 0; i < res.length; i++) {
		qcs[i] = res[i].qc;
		counts[i] = res[i].count;
	}
	var ctx = document.getElementById("uncalled").getContext('2d');
	var myChart = new Chart(ctx, {
		type : 'bar',
		data : {
			labels : qcs,
			datasets : [ {
				label : '# uncalled',
				data : counts,
				backgroundColor : [ 'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)' ],
				borderColor : [ 'rgba(255,99,132,1)', 'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
						'rgba(255,99,132,1)' ],
				borderWidth : 1
			} ]
		},
		options : {
			scales : {
				yAxes : [ {
					ticks : {
						beginAtZero : true
					}
				} ]
			}
		}
	});

})

$.post("charts/totalcalled", "", function(data) {
	var qcs = [], counts = [];
	res = JSON.parse(data);
	for (i = 0; i < res.length; i++) {
		qcs[i] = res[i].qc;
		counts[i] = res[i].count;
	}
	var ctx = document.getElementById("totalcalled").getContext('2d');
	var myChart = new Chart(ctx, {
		type : 'bar',
		data : {
			labels : qcs,
			datasets : [ {
				label : '# TotalCalled',
				data : counts,
				borderWidth : 1
			} ]
		},
		options : {
			scales : {
				yAxes : [ {
					ticks : {
						beginAtZero : true
					}
				} ]
			}
		}
	});

})
