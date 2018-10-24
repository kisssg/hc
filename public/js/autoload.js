$(document).ready(function () {
    $.datetimepicker.setLocale('ch');
    $(".datepicker").datetimepicker({
        format : 'Y-m-d',
        timepicker : false
    });

    $(".datetimepicker").datetimepicker({
        format : 'Y-m-d H:i:s'
    });

    $('#videoScoreBoard').on('show.bs.modal', function (e) {

        // initialize when show the video score board.

        var button = $(e.relatedTarget);
        var id = button.data("id");
        var action = button.data("action");
        var table = $("#" + id);
        VideoScoreCard.onObjectChange('hideAllNoShow');
        if (action == "add") {
            // find text;
            visit_result = (table.find('.visit_result_cn').text());
            journal_creator = table.find(".journal_creator").text();
            contract_no = table.find(".contract_no").text();
            visit_date = table.find(".visit_date").text();
            visit_time = table.find(".visit_time").text();
            validity = table.find(".validity").text();
            // find hidden values;
            negotiator_cn = table.find(".negotiator_cn").val();
            employee_code = table.find(".employee_code").val();
            city = table.find(".city").val();
            addr_sign_in = table.find(".addr_sign_in").val();
            addr_detail = table.find(".addr_detail").val();
            journalID = table.find(".journalID").val();

            // fetch sign-in data

            //VideoScoreCard.showSignIns(journal_creator, visit_date, contract_no);

            // initialize values on the score board.

            $("#journalID").val(journalID);
            $("#visit_result").text(visit_result);
            $("#journal_creator").text(journal_creator);
            $("#contract_no").text(contract_no);
            $("#visit_date_card").text(visit_date);
            $("#visit_time").text(visit_time).css("color", "black");
            $("#employee_code").text(employee_code);
            $("#addr_sign_in").text(addr_sign_in);
            $("#addr_detail").text(addr_detail).css("color", "black");
            $("#city").text(city);
            $("#validity").text(validity);
            $("#negotiator_cn").text(negotiator_cn);

            // initialize score
            $("#score").text(100);
            $(".judgeResults").text("");
            // initialize user input box
            $("#duration").val("");
            $("#object").val("");
            $("#videoName").val("");
            $("#remark").val("");
            $("#tips").text("");

            // initialize the html tag for video info adding
            $(".videoInfoFrame").remove();
            $(".auditFrame").remove();
            VideoScoreCard.addVideoInfo();
        } else {
            // find text;
            visit_result = (table.find('.visitResult').text());
            journal_creator = table.find(".LLI").text();
            contract_no = table.find(".contractNo").text();
            visit_date = table.find(".visitDate").text();
            visit_time = table.find(".visitTime").text();
            validity = "无";
            score = table.find(".score").text();
            // find hidden values;
            negotiator_cn = table.find(".negotiator_cn").val();
            employee_code = table.find(".employeeID").val();
            city = table.find(".city").val();
            signInAddr = table.find(".signInAddr").val();
            journalID = table.find(".journalID").val();
            object = table.find(".object").val();
            remark = table.find(".remark").val();
            videoInfo = table.find(".videoInfo").val();
            auditResult = table.find(".auditResult").val();
            
            //call onObjectChange();
            VideoScoreCard.onObjectChange(object);

            // get scores
            announceRec=table.find('.announceRec').val();
            visitLocation=table.find('.visitLocation').val();
            objectionHandling=table.find('.objectionHandling').val();
            InfoInvestigation=table.find('.InfoInvestigation').val();
            matchedVisitResult=table.find('.matchedVisitResult').val();
            uploadOntime=table.find('.uploadOntime').val();
            IDVerification=table.find('.IDVerification').val();
            selfIntroduction=table.find('.selfIntroduction').val();
            infoProviding=table.find('.infoProviding').val();
            paymentChannel=table.find('.paymentChannel').val();
            approvedCashCollect=table.find('.approvedCashCollect').val();
            dataIntegrality=table.find('.dataIntegrality').val();
            wrongInfo=table.find('.wrongInfo').val();
            attitude=table.find('.attitude').val();
            cheating=table.find('.cheating').val();
            informationLeakage=table.find('.informationLeakage').val();
            urgentNoReport=table.find('.urgentNoReport').val();
            acceptWaiving=table.find('.acceptWaiving').val();
            sensitiveWording=table.find('.sensitiveWording').val();
            description=table.find('.description').val();


            // show the signIns

            //VideoScoreCard.showSignIns(journal_creator, visit_date, contract_no);

            // initialize values on the score board
            $("#negotiator_cn").text(negotiator_cn);
            $("#journalID").val(journalID);
            $("#visit_result").text(visit_result);
            $("#journal_creator").text(journal_creator);
            $("#contract_no").text(contract_no);
            $("#visit_date_card").text(visit_date);
            $("#visit_time").text(visit_time);
            $("#employee_code").text(employee_code);
            $("#addr_detail").text(signInAddr);
            $("#city").text(city);
            $("#validity").text(validity);
            $("#score").text(score);

            // set score
            $('#announceRec').text(announceRec);
            $('#visitLocation').text(visitLocation);
            $('#objectionHandling').text(objectionHandling);
            $('#InfoInvestigation').text(InfoInvestigation);
            $('#matchedVisitResult').text(matchedVisitResult);
            $('#uploadOntime').text(uploadOntime);
            $('#IDVerification').text(IDVerification);
            $('#selfIntroduction').text(selfIntroduction);
            $('#infoProviding').text(infoProviding);
            $('#paymentChannel').text(paymentChannel);
            $('#approvedCashCollect').text(approvedCashCollect);
            $('#dataIntegrality').text(dataIntegrality);
            $('#wrongInfo').text(wrongInfo);
            $('#attitude').text(attitude);
            $('#cheating').text(cheating);
            $('#informationLeakage').text(informationLeakage);
            $('#urgentNoReport').text(urgentNoReport);
            $('#acceptWaiving').text(acceptWaiving);
            $('#sensitiveWording').text(sensitiveWording);
            $('#description').text(description);
            
            
            // initialize user input box
            $("#object").val(object);
            $("#remark").val(remark);
            videoInfo = JSON.parse(videoInfo);
            $(".videoInfoFrame").remove();
            for (i = 0; i < videoInfo.length; i++) {
                VideoScoreCard.addVideoInfo(videoInfo[i].name, videoInfo[i].duration,videoInfo[i].createDate,videoInfo[i].createTime,videoInfo[i].uploadDate,videoInfo[i].uploadTime);
            }
            $("#tips").text("");
            if (action == "edit") {
                $("#scoreSubmitBtn").attr("onclick", "return VideoScore.update(" + id + ");");
                $("#scoreSubmitBtn").text("保存");
                $(".auditFrame").remove();
            } else {
                VideoScoreCard.showAuditHtml();
                $(".auditDelBtn").remove();
                if (auditResult != "blank") {
                    // if the score has audited,show the audit result.                    
                    VideoAudits.fillData(id);
                    VideoScoreCard.showAuditDelBtn(id);
                }
                $("#remark").prop("disabled", true);
                $("#scoreSubmitBtn").attr("onclick", "return VideoAudits.Add("+id+");");
                $("#scoreSubmitBtn").text("提交内审结果");
            }
        }
    });

    $(".videoScore").change(function () {
        // update total score when item score change
        scoreArr = $(".videoScore")
        var totalScore = 0;
        for (i = 0; i < scoreArr.length; i++) {
            totalScore += Number(scoreArr[i].value);
        }
        $("#score").text(totalScore);
    });
});