var VideoScore = {
    add: function(id) {
	eachDuration = $(".duration");
	eachVideoName = $(".videoName");
	eachCreateDate=$('.videoCreateDate');
	eachUploadDate=$('.videoUploadDate');
	eachCreateTime=$('.videoCreateTime');
	eachUploadTime=$('.videoUploadTime');
	
	videoCreateDate=eachCreateDate[0].value;
	videoCreateTime=eachCreateTime[0].value;
	videoUploadDate=eachUploadDate[0].value;
	videoUploadTime=eachUploadTime[0].value;


	// videoInfo1 = "";
	duration=0;
	var videoInfo=[];
	for (i = 0; i < eachDuration.length; i++) {
	    vName = (eachVideoName[i].value).replace(/[\]\[\|\'\\\/\"]/g,"");
	    vDuration = eachDuration[i].value;
	    if (vName == "" || !Validator.checkLongTimeFormat(vDuration)) {
		$("#tips").text(
			"videoName和duration不能为空,duration格式为hh:mm:ss,如01:05:26！");
		return;
	    }
	    ms = vDuration.split(":");
	    h=Number(ms[0]);
        m=Number(ms[1]);
        s=Number(ms[2]);
	    duration += h*3600 + m*60 +s;
	    
	    vCreateDate=(eachCreateDate[i].value);
	    vUploadDate=(eachUploadDate[i].value);
	    vCreateTime=(eachCreateTime[i].value);
	    vUploadTime=(eachUploadTime[i].value);
	    
	    if(!Validator.checkDateFormat(vCreateDate)||
	            !Validator.checkLongTimeFormat(vCreateTime)||
	            !Validator.checkDateFormat(vUploadDate)||
	            !Validator.checkLongTimeFormat(vUploadTime)){
        $("#tips").text(
            "时间日期格式不对。");
        return;	        
	    }
	    
	    var info={
		    "name":vName,
		    "duration":vDuration,
		    'createDate':vCreateDate,
		    'uploadDate':vUploadDate,
		    'createTime':vCreateTime,
		    'uploadTime':vUploadTime
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
	negotiator=$('#negotiator_cn').text();
	obj = $('#object').val();
	if(obj=="" || obj==null){
	    $("#tips").text("Object不能为空！");
	    return;
	}
	// score items
	// @TODO: send result to back end
	announceRec=$('#announceRec').text();
	visitLocation=$('#visitLocation').text();
	objectionHandling=$('#objectionHandling').text();
	InfoInvestigation=$('#InfoInvestigation').text();
	score=$('#score').text();
	matchedVisitResult=$('#matchedVisitResult').text();
	uploadOntime=$('#uploadOntime').text();
	IDVerification=$('#IDVerification').text();
	selfIntroduction=$('#selfIntroduction').text();
	infoProviding=$('#infoProviding').text();
	paymentChannel=$('#paymentChannel').text();
	approvedCashCollect=$('#approvedCashCollect').text();
	dataIntegrality=$('#dataIntegrality').text();
	wrongInfo=$('#wrongInfo').text();
	attitude=$('#attitude').text();
	cheating=$('#cheating').text();
	informationLeakage=$('#informationLeakage').text();
	urgentNoReport=$('#urgentNoReport').text();
	acceptWaiving=$('#acceptWaiving').text();
	sensitiveWording=$('#sensitiveWording').text();

	description = $('#description').text();
	remark = ($('#remark').val()).replace(/[\"]/g,"''");
	score = $('#score').text();
	QC = $('#qc').text();
	journalID = $('#journalID').val();

	args = {
	        'id':id,
	        'videoInfo':videoInfo,
	        'city':city,
	        'LLI':LLI,
	        'contractNo':contractNo,
	        'visitDate':visitDate,
	        'visitTime':visitTime,
	        'employeeID':employeeID,
	        'signInAddr':signInAddr,
	        'visitResult':visitResult,
	        'negotiator':negotiator,
	        'object':obj,
	        'announceRec':announceRec,
	        'visitLocation':visitLocation,
	        'objectionHandling':objectionHandling,
	        'InfoInvestigation':InfoInvestigation,
	        'score':score,
	        'matchedVisitResult':matchedVisitResult,
	        'uploadOntime':uploadOntime,
	        'IDVerification':IDVerification,
	        'selfIntroduction':selfIntroduction,
	        'infoProviding':infoProviding,
	        'paymentChannel':paymentChannel,
	        'approvedCashCollect':approvedCashCollect,
	        'dataIntegrality':dataIntegrality,
	        'wrongInfo':wrongInfo,
	        'attitude':attitude,
	        'cheating':cheating,
	        'informationLeakage':informationLeakage,
	        'urgentNoReport':urgentNoReport,
	        'acceptWaiving':acceptWaiving,
	        'sensitiveWording':sensitiveWording,
	        'duration':duration,
	        'description':description,
	        'remark':remark,
	        'score':score,
	        'QC':QC,
	        'journalID':journalID,
	        'videoCreateDate':videoCreateDate,
	        'videoCreateTime':videoCreateTime,
	        'videoUploadDate':videoUploadDate,
	        'videoUploadTime':videoUploadTime,	        
	};
	console.log(args);
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
    addVideoInfo : function(name,duration,createDate,createTime,uploadDate,uploadTime) {
	rid = Math.ceil(Math.random() * 1000);
	if(name==undefined || duration== undefined){
	    name="";
	    duration="";
	    createDate="";
	    uploadDate="";
	    createTime="";
	    uploadTime="";
	}
	videoInfoHtml = '<tr class="videoInfoFrame" id="videoInfo'
		+ rid
		+ '"><td>'
		+ '<label for="videoName" class="control-label">Video Name：'
		+ '</label><input type="text" class="form-control input-sm videoName" id="" value="' + name + '">'
        + '<label for="duration" class="control-label">Duration：</label>'
        + '<input type="text" class="form-control input-sm duration" id="" value="' + duration + '" placeholder="hh:mm:ss">'
		+ '</td><td>'
        + '<label for="videoCreateDate" class="control-label">CreateDate：</label>'
        + '<input type="text" class="form-control input-sm videoCreateDate" id="" value="' + createDate + '" placeholder="yyyy/mm/dd">'
        + '<label for="videoUploadDate" class="control-label">UploadDate：</label>'  
        + '<input type="text" class="form-control input-sm videoUploadDate" id="" value="' + uploadDate + '" placeholder="yyyy/mm/dd">'
		+ '</td><td><div class="row"><div class="col-md-5">'
        + '<label for="videoCreateTime" class="control-label">CreateTime：</label>'
        + '<input type="text" class="form-control input-sm videoCreateTime" id="" value="' + createTime + '" placeholder="hh:mm:ss">'
        + '<label for="videoUploadTime" class="control-label">UploadTime：</label>'
        + '<input type="text" class="form-control input-sm videoUploadTime" id="" value="' + uploadTime + '" placeholder="hh:mm:ss">'
		+ '</div><div class="col-md-5">'
		+ '<button onclick="return VideoScoreCard.addVideoInfo();"><span class="glyphicon glyphicon-plus"></span></button>'
        + '<button onclick="return VideoScoreCard.removeVideoInfo('
        + rid
        + ');"><span class="glyphicon glyphicon-minus"></span></button>'
        + '<button onclick="return VideoScoreCard.nullVideoInfo('
        + rid
        + ');"><span class="glyphicon glyphicon-eye-close"></span></button>'
		+ '</div></div></td></tr>';
	$("#videoBottom").before(videoInfoHtml);
    },
    removeVideoInfo : function(id) {
	if ($(".videoInfoFrame").length == 1) {
	    return;
	}
	videoInfoHtml = $("#videoInfo" + id);
	cf=true;
    if(videoInfoHtml.find('.videoName').val()!=''){
        cf=confirm('数据不为空，是否继续?')        
    }
    if(cf){
        videoInfoHtml.remove();        
    }
    },
    nullVideoInfo:function(id){
        videoInfoHtml = $("#videoInfo" + id);
        cf=true;
        if(videoInfoHtml.find('.videoName').val()!=''){
            cf=confirm('数据不为空，是否继续?');            
        }
        if(cf){
            videoInfoHtml.find('.videoName').val('null');
            videoInfoHtml.find('.duration').val('null');
            videoInfoHtml.find('.videoCreateDate').val('null');
            videoInfoHtml.find('.videoUploadDate').val('null');
            videoInfoHtml.find('.videoCreateTime').val('null');
            videoInfoHtml.find('.videoUploadTime').val('null');            
        }
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
        },
        judge:function(id,result){
            if(result=='清除'){
                $("#"+id).text('');                
            }else if(Number($("#"+id).text())==0 || result==0){
                $("#"+id).text(result);      
            }else{
                $("#"+id).append(',',result);
            }
            VideoScoreCard.calcScore();
        },
        onObjectChange:function(obj){
            $(".NOTPC").show();
            $(".NONPC").show();
            $(".NOWPC").show();
            
            if(obj=="TPC"){
                $(".NOTPC").hide();
                $(".NOTPC").find(".judgeResults").text('');
            }
            if(obj=="NPC"){
                $(".NONPC").hide();
                $(".NONPC").find(".judgeResults").text('');
            }
            if(obj=="WPC"){
                $(".NOWPC").hide();
                $(".NOWPC").find(".judgeResults").text('');
            }
            VideoScoreCard.calcScore();
        },
        calcScore:function(){
            obj = $("#object").val();
            scoreArr = $(".judgeResults")
            scoreRef = {
                "RPC" : {
                    'description' : 10,
                    'visitLocation' : 5,
                    'matchedVisitResult' : 10,
                    'uploadOntime' : 10,
                    'IDVerification' : 10,
                    'selfIntroduction' : 5,
                    'objectionHandling' : 10,
                    'infoProviding' : 10,
                    'InfoInvestigation' : 5,
                    'announceRec' : 10,
                    'paymentChannel' : 5,
                    'approvedCashCollect' : 10
                },
                "TPC" : {
                    'description' : 15,
                    'visitLocation' : 10,
                    'matchedVisitResult' : 10,
                    'uploadOntime' : 10,
                    'IDVerification' : 10,
                    'selfIntroduction' : 10,
                    'objectionHandling' : 10,
                    'infoProviding' : 15,
                    'InfoInvestigation' : 10,
                    'announceRec' : 0,
                    'paymentChannel' : 0,
                    'approvedCashCollect' : 0,
                },
                "WPC" : {
                    'description' : 20,
                    'visitLocation' : 20,
                    'matchedVisitResult' : 20,
                    'uploadOntime' : 20,
                    'IDVerification' : 20,
                    'selfIntroduction' : 0,
                    'objectionHandling' : 0,
                    'infoProviding' : 0,
                    'InfoInvestigation' : 0,
                    'announceRec' : 0,
                    'paymentChannel' : 0,
                    'approvedCashCollect' : 0,
                },
                "NPC" : {
                    'description' : 25,
                    'visitLocation' : 25,
                    'matchedVisitResult' : 25,
                    'uploadOntime' : 25,
                    'IDVerification' : 0,
                    'selfIntroduction' : 0,
                    'objectionHandling' : 0,
                    'infoProviding' : 0,
                    'InfoInvestigation' : 0,
                    'announceRec' : 0,
                    'paymentChannel' : 0,
                    'approvedCashCollect' : 0
                }
            }
            if (obj == 'RPC') {
                scf = scoreRef.RPC
            } else if (obj == 'TPC') {
                scf = scoreRef.TPC
            } else if (obj == 'WPC') {
                scf = scoreRef.WPC
            } else if (obj == 'NPC') {
                scf = scoreRef.NPC
            }
            deductScore = 0;
            for (i = 0; i < scoreArr.length; i++) {
                if (Number(scoreArr[i].textContent) != 0) {
                    switch (scoreArr[i].id) {
                    case 'description':
                        deductScore += scf.description;
                        break;
                    case 'visitLocation':
                        deductScore += scf.visitLocation;
                        break;
                    case 'matchedVisitResult':
                        deductScore += scf.matchedVisitResult;
                        break;
                    case 'uploadOntime':
                        deductScore += scf.uploadOntime;
                        break;
                    case 'IDVerification':
                        deductScore += scf.IDVerification;
                        break;
                    case 'selfIntroduction':
                        deductScore += scf.selfIntroduction;
                        break;
                    case 'objectionHandling':
                        deductScore += scf.objectionHandling;
                        break;
                    case 'infoProviding':
                        deductScore += scf.infoProviding;
                        break;
                    case 'InfoInvestigation':
                        deductScore += scf.InfoInvestigation;
                        break;
                    case 'announceRec':
                        deductScore += scf.announceRec;
                        break;
                    case 'paymentChannel':
                        deductScore += scf.paymentChannel;
                        break;
                    case 'approvedCashCollect':
                        deductScore += scf.approvedCashCollect;
                        break;
                    }
                }
            }
            var totalScore = 100 - deductScore;
            $("#score").text(totalScore);
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
        if(str=='null')
            return true;
	var result = str.match(/^(\d{1,3})(:)(\d{1,2})$/);
	if (result == null)
	    return false;
	return (result[1] < 999 && result[3] < 60);
    },
    checkDateFormat: function(str){
        if(str=='null')
            return true;
        var result= str.match(/^(\d{4})(-)(\d{1,2})(-)(\d{1,2})$/);
        if(result==null)
            return false;
        return (result[3]<13 && result[5] < 32);
    },
    checkLongTimeFormat:function(str){
        if(str=='null')
            return true;
        var result=str.match(/^(\d{1,2})(:)(\d{1,2})(:)(\d{1,2})$/);
        if(result==null)
            return false;
        return (result[1]<25 && result[3]<60 && result[5] < 60);
    }
}