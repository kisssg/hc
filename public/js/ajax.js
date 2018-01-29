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
var SignIn={
		login:function(){
			alert(0);
		}
}

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan-Feb", "Mar-Apr", "May-Jun", "Jul-Aug", "Sep-Oct", "Nov-Dec"],
        datasets: [{
            label: '#of visit checking',
            data: [128945, 195642, 316454, 545646, 244155, 345451],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});