var VideoScore = {
    name : "",
    addScore : function() {
	eachDuration = $(".duration");
	eachVideoName = $(".videoName");
	videoInfo = "";
	duration=0;
	for (i = 0; i < eachDuration.length; i++) {
	    vName = eachVideoName[i].value;
	    vDuration = eachDuration[i].value;
	    if (vName == "" || vDuration == ""
		    || !Validator.checkTimeFormat(vDuration)) {
		$("#tips").text(
			"videoName和duration不能为空,duration格式为mm:ss,如05:26！");
		return;
	    }
	    ms = vDuration.split(":");
	    m=Number(ms[0]);
	    s=Number(ms[1]);
	    duration += m*60 +s;
	    videoInfo += '[' + vName + '|' + vDuration + ']';
	}
	city = $("#city").text();
	LLI = $("#journal_creator").text();
	contractNo = $("#contract_no").text();
	visitDate = $('#visit_date_card').text();
	visitTime = $('#visit_time').text();
	employeeID = $('#employee_code').text();
	signInAddr = $('#addr_detail').text() + $("#addr_sign_in").text();
	visitResult = $('#visit_result').text();
	object = $('#object').val();
	if(object==""){
	    $("#tips").text("Object不能为空！");
	    return;
	}
	// scores
	integrality = $('#integrality').val();
	description = $('#description').val();
	announcement = $('#announcement').val();
	scoreLocation = $('#location').val();
	objectionHandling = $('#objectionHandling').val();
	noHarassment = $('#noHarassment').val();
	getPTP = $('#getPTP').val();
	skipTrace = $('#skipTrace').val();
	remark = $('#remark').val();
	complaintIndicator = $('#complaintIndicator').val();

	score = $('#score').text();
	QC = $('#qc').text();
	journalID = $('#journalID').val();

	args = {
	    'contractNo' : contractNo,
	    'visitDate' : visitDate,
	    'visitTime' : visitTime,
	    'LLI' : LLI,
	    'employeeID' : employeeID,
	    'city' : city,
	    'signInAddr' : signInAddr,
	    'visitResult' : visitResult,
	    'duration' : duration,
	    'object' : object,
	    'videoInfo' : videoInfo,
	    'integrality' : integrality,
	    'description' : description,
	    'announcement' : announcement,
	    'location' : scoreLocation,
	    'objectionHandling' : objectionHandling,
	    'noHarassment' : noHarassment,
	    'getPTP' : getPTP,
	    'skipTrace' : skipTrace,
	    'score' : score,
	    'remark' : remark,
	    'complaintIndicator' : complaintIndicator,
	    'QC' : QC,
	    'journalID' : journalID,
	};
	url = "vrdScoreAdd";
	$('#tips').text("提交中...");
	$("#scoreSubmitBtn").attr("disabled", true);
	$.post(url, args, function(data) {
	    alert(data);
	    $("#scoreSubmitBtn").attr("disabled", false);
	    $("#videoScoreBoard").modal("hide");
	});

    },
    deleteScore : function(id) {
	alert(id + " deleted!");
    },
    updateScore : function(id) {
	alert(id + " updated!");
    },
}
var VideoScoreCard = {
    addVideoInfo : function() {
	rid = Math.ceil(Math.random() * 1000);
	videoInfoHtml = '<tr class="videoInfo" id="videoInfo'
		+ rid
		+ '"><td colspan="2">'
		+ '<label for="videoName" class="control-label">Video Name：'
		+ '</label><input type="text" class="form-control input-sm videoName" id="" value="">'
		+ '</td><td><div class="row"><div class="col-md-5">'
		+ '<label for="duration" class="control-label">Duration：</label>'
		+ '<input type="text" class="form-control input-sm duration" id="" value="">'
		+ '</div><div class="col-md-5">'
		+ '<button onclick="return VideoScoreCard.addVideoInfo();"><span class="glyphicon glyphicon-plus"></span></button>'
		+ '<button onclick="return VideoScoreCard.removeVideoInfo('
		+ rid
		+ ');"><span class="glyphicon glyphicon-minus"></span></button>'
		+ '</div></div></td></tr>';
	$("#videoBottom").before(videoInfoHtml);
    },
    removeVideoInfo : function(id) {
	if ($(".videoInfo").length == 1) {
	    return;
	}
	;
	videoInfoHtml = $("#videoInfo" + id);
	videoInfoHtml.remove();
    }
}
var Validator = {
    checkTimeFormat : function(str) {
	var result = str.match(/^(\d{1,3})(:)(\d{1,2})$/);
	if (result == null)
	    return false;
	return (result[1] < 999 && result[3] < 60);
    }
}