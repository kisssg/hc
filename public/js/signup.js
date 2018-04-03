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
		if (SignUp.check("username") == false) {
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
		username = $("#username")[0].value;
		email = $("#email")[0].value;
		args = {
			"username" : username,
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