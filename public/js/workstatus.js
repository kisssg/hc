var WorkStatus = {
	grant: function (id) {
		duration = Number(prompt("How many minutes would you want to grant?", 10));
		if (isNaN(duration) || duration < 1) {
			return;
		}
		URL = window.location.href;
		baseDir = URL.split("/")[3];
		var t = moment().format('YYYY-MM-DD kk:mm:ss');
		deadline = moment(t, 'YYYY-MM-DD kk:mm:ss').add(duration, "m").format('YYYY-MM-DD kk:mm:ss');
		//alert(deadline);
		permissionUrl = "/" + baseDir + "/workstatus/grant/" + id + "/" + deadline;
		$.post(permissionUrl, "", function (data) {
			result = JSON.parse(data).result;
			if (result == "OK") {
				window.location.reload();
			} else {
				alert(result);
			}
		})
		return;
	}
}