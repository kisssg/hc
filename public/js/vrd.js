var VideoScore = {
    add: function(id) {
	eachDuration = $(".duration");
	eachVideoName = $(".videoName");
	// videoInfo1 = "";
	duration=0;
	var videoInfo=[];
	for (i = 0; i < eachDuration.length; i++) {
	    vName = (eachVideoName[i].value).replace(/[\]\[\|\'\\\/\"]/g,"");
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
	    // videoInfo1 += '[' + vName + '|' + vDuration + ']';
	    var info={
		    "name":vName,
		    "duration":vDuration
	    }
	    videoInfo.push(info );
	}
	videoInfo=JSON.stringify(videoInfo);
	city = $("#city").text();
	LLI = $("#journal_creator").text();
	contractNo = $("#contract_no").text();
	visitDate = $('#visit_date_card').text();
	visitTime = $('#visit_time').text();
	employeeID = $('#employee_code').text();
	signInAddr = $('#addr_detail').text() + $("#addr_sign_in").text();
	visitResult = $('#visit_result').text();
	object = ($('#object').val()).replace(/[\"]/g,"''");
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
	remark = ($('#remark').val()).replace(/[\"]/g,"''");
	complaintIndicator = $('#complaintIndicator').val();

	score = $('#score').text();
	QC = $('#qc').text();
	journalID = $('#journalID').val();

	args = {
	    'id':id,
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
	    res=JSON.parse(data);
	    if(res.result=="success"){
		if(id>0){
			$("#tips").text("成功保存！");
			window.location.reload();		    
		}else{
			$("#tips").text("添加成功！");
			$("#videoScoreBoard").modal("hide");		    
		}
	    }else{
		$("#tips").text(res.msg);
	    }
	    $("#scoreSubmitBtn").attr("disabled", false);	    
	});

    },
    delete: function(id) {
	cf=confirm("确定要删除吗？");
	if(cf===true){
	arg={"id":id}
	url="vrdScoreDel";
	$.post(url,arg,function(data){
	    res=JSON.parse(data);
	    if(res.result=="success"){
		alert("success");
		window.location.reload();
	    }else{
		alert("删除失败！"+res.msg);
	    }
	});
	}
    },
    update: function(id) {
	this.add(id);
    }
}
var VideoScoreCard = {
    addVideoInfo : function(name,duration) {
	rid = Math.ceil(Math.random() * 1000);
	if(name==undefined || duration== undefined){
	    name="";
	    duration="";
	}
	videoInfoHtml = '<tr class="videoInfoFrame" id="videoInfo'
		+ rid
		+ '"><td colspan="2">'
		+ '<label for="videoName" class="control-label">Video Name：'
		+ '</label><input type="text" class="form-control input-sm videoName" id="" value="' + name + '">'
		+ '</td><td><div class="row"><div class="col-md-5">'
		+ '<label for="duration" class="control-label">Duration：</label>'
		+ '<input type="text" class="form-control input-sm duration" id="" value="' + duration + '" placeholder="mm:ss">'
		+ '</div><div class="col-md-5">'
		+ '<button onclick="return VideoScoreCard.addVideoInfo();"><span class="glyphicon glyphicon-plus"></span></button>'
		+ '<button onclick="return VideoScoreCard.removeVideoInfo('
		+ rid
		+ ');"><span class="glyphicon glyphicon-minus"></span></button>'
		+ '</div></div></td></tr>';
	$("#videoBottom").before(videoInfoHtml);
    },
    removeVideoInfo : function(id) {
	if ($(".videoInfoFrame").length == 1) {
	    return;
	}
	videoInfoHtml = $("#videoInfo" + id);
	videoInfoHtml.remove();
    },
    showSignIns:function(journal_creator,visit_date,contract_no){
        url = "/qm/vc_get_signin.php?t=" + Math.random()
        args = {
            "llc" : journal_creator,
            "visit_date" : visit_date,
            "contract_no" : contract_no
        }
        $(".signInAddrFrame").remove();
        $("#objectTr").before("<tr class='waitingText'><td colspan='3'>等待签到数据...</td></tr>");
        $.post(url,args,function (data) {
                            res = JSON.parse(data);
                            $(".waitingText").remove();
                            for (i in res) {
                                $("#objectTr").before("<tr class='signInAddrFrame'><td colspan='3'>"
                                                        + (Number(i) + 1)
                                                        + ".<span class='addrSignIn'>"
                                                        + res[i].addr_detail
                                                        + res[i].addr
                                                        + "</span> <span class='signTime'>"
                                                        + res[i].sign_in_time
                                                        + "</span><button class='btn btn-primary btn-xs' onclick='VideoScoreCard.replaceSignIn(\"" 
                                                        + res[i].sign_in_time
                                                        +"\",\"" + res[i].addr_detail
                                                        + res[i].addr                                                        		
                                                        +"\")'>匹配签到</button></td></tr>");
                            }
                        });
        },
    replaceSignIn:function(signTime,signAddr){
            $("#visit_time").text(signTime).css("color","red");
            $("#addr_detail").text(signAddr).css("color","red");
            $("#addr_sign_in").text("");
        },
    showAuditHtml:function(){
            var auditHtml = '<tr class="auditFrame"><td colspan="3"><div class="row"><div class="col-md-7">Audit Result:</div><div class="col-xs-2">'
                    + '<select class="form-control input-sm" id="auditResult"><option>N</option><option>Y</option></select></div></div></td></tr>'
                    + '<tr class="auditFrame"><td colspan="3"><div class="form-group"><label for="auditRemark" class="col-sm-2 control-label">Audit Remark：</label>'
                    + '<div class="col-sm-10">'
                    + '<textarea class="form-control" id="auditRemark" rows="5" onkeyup="" maxlength="500" placeholder="auditRemark"></textarea>'
                    + '</div></div></td></tr>';
            $(".auditFrame").remove();
            $("#tableBottom").after(auditHtml);
            $("#auditResult").val("");
        },
        showAuditDelBtn:function(vsID){
            auditDelBtn='<button class="btn auditDelBtn" onclick="return VideoAudits.delete('+vsID+')">删除内审</button>';
            $("#scoreSubmitBtn").before(auditDelBtn);
        }
}
var VideoAudits={
        Add:function(vsID){
            contractNo = $("#contract_no").text();
            visitDate = $('#visit_date_card').text();
            visitTime = $('#visit_time').text();
            result = $("#auditResult").val();
            remark = $("#auditRemark").val();
            url="../videoaudit/add";
            args={
                    "contractNo":contractNo,
                    "visitDate":visitDate,
                    "visitTime":visitTime,
                    "result":result,
                    "remark":remark,
                    "vsID":vsID
            }
            $.post(url,args,function(data){
                re=JSON.parse(data);
                if(re.result=="success"){
                    $("#tips").text("添加成功！");
                    $("#videoScoreBoard").modal("hide");
                    $("[data-id='"+vsID+"'][data-action='audit']").removeClass("btn-default")
                    .addClass("btn-primary").text("审核"+result);
                    $("#"+vsID).find(".auditResult").val(result);
                }else{
                    $("#tips").text("提交失败！"+re.msg);
                }
            })
        },
        fillData:function(vsID){
            ra=Math.ceil(Math.random() * 100);
            url="../videoaudit/get?"+ra;
            args={
                    "vsID":vsID
            }
            $.post(url,args,function(data){
                re=JSON.parse(data);
                $("#auditResult").val(re.result);
                $("#auditRemark").val(re.remark);                
            });
        },
        delete:function(vsID){
            cf=confirm("确定清除内审数据吗？");
            if(cf){
                ra=Math.ceil(Math.random() * 100);
                url="../videoaudit/delete?"+ra;
                args={
                        "vsID":vsID
                }                
                $.post(url,args,function(data){
                    re=JSON.parse(data);
                    if(re.result=="success"){
                        $("#auditResult").val("");
                        $("#auditRemark").val("");
                        $(".auditDelBtn").remove();
                        $("[data-id='"+vsID+"'][data-action='audit']").removeClass("btn-primary")
                        .addClass("btn-default").text("审核");
                        $("#"+vsID).find(".auditResult").val("blank");                           
                    }else{
                        alert(re.msg);
                    }
                });
            }
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