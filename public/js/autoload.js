$(document).ready(
        function () {
            $.datetimepicker.setLocale('ch');
            $(".datepicker").datetimepicker({
                format : 'Y-m-d',
                timepicker : false
            });

            $(".datetimepicker").datetimepicker({
                format : 'Y-m-d H:i:s'
            });
            
            $('#cameraScoreBoard').on(
                    'show.bs.modal',
                    function (e) {

                        // initialize when show the video score board.

                        var button = $(e.relatedTarget);
                        var id = button.data("id");
                        var action = button.data("action");
                        var table = $("#" + id);
                        
                        CameraScoreCard.onObjectChange('hideAllNoShow');
                        if (action == "add") {
                            // find text;
                            visit_result = (table.find('.visit_result_cn').text());
                            journal_creator = table.find(".journal_creator").text();
                            contract_no = table.find(".contract_no").text();
                            visit_date = table.find(".visit_date").text();
                            visit_time = table.find(".visit_time").text();
                            validity = table.find(".validity").text();
                            
                            CREATE_TIME= table.find(".CREATE_TIME").text();
                            ENDING_TIME= table.find(".ENDING_TIME").text();
                            CNT_VIDEO_RECORDS= table.find(".CNT_VIDEO_RECORDS").text();
                            CNT_AUDIO_RECORDS= table.find(".CNT_AUDIO_RECORDS").text();
                            
                            // find hidden values;
                            negotiator_cn = table.find(".negotiator_cn").val();
                            employee_code = table.find(".employee_code").val();
                            city = table.find(".city").val();
                            addr_sign_in = table.find(".addr_sign_in").val();
                            addr_detail = table.find(".addr_detail").val();
                            journalID = table.find(".journalID").val();                            
                            

                            // fetch sign-in data

                            // VideoScoreCard.showSignIns(journal_creator, visit_date, contract_no);

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
                            
                            $("#CREATE_TIME").text(CREATE_TIME);
                            $("#ENDING_TIME").text(ENDING_TIME);
                            $("#CNT_VIDEO_RECORDS").text(CNT_VIDEO_RECORDS);
                            $("#CNT_AUDIO_RECORDS").text(CNT_AUDIO_RECORDS);

                            // initialize score
                            $("#score").text(100);
                            $(".judgeResults").text("");
                            // initialize user input box
                            $("#duration").val("");
                            $("#object").val("");
                            $("#videoName").val("");
                            $("#remark").val("");
                            $("#tips").text("");
                            

                            $('#cheatType').val("");
                            $('#noIntroAnno').val("");
                            boxes=document.getElementsByName("noIntroAnnoTypes");
                            for(i=0;i<boxes.length;i++){
                                boxes.checked=false;
                            }

                            // initialize the html tag for video info adding
                            $(".videoInfoFrame").remove();
                            $(".auditFrame").remove();

                            $("#object").prop("disabled", false);
                            $("#remark").prop("disabled", false);
                            $("#scoreSubmitBtn").attr("onclick", "return CameraScore.add();");
                            $("#scoreSubmitBtn").text("提交");
                            
                            //CameraScoreCard.addVideoInfo();
                        } else {
                         // find text;
                            visit_result = (table.find('.visit_result_cn').text());
                            journal_creator = table.find(".journal_creator").text();
                            contract_no = table.find(".contract_no").text();
                            visit_date = table.find(".visit_date").text();
                            visit_time = table.find(".visit_time").text();
                            validity = table.find(".validity").text();
                            
                            CREATE_TIME= table.find(".CREATE_TIME").text();
                            ENDING_TIME= table.find(".ENDING_TIME").text();
                            CNT_VIDEO_RECORDS= table.find(".CNT_VIDEO_RECORDS").text();
                            CNT_AUDIO_RECORDS= table.find(".CNT_AUDIO_RECORDS").text();
                            
                            // find hidden values;
                            negotiator_cn = table.find(".negotiator_cn").val();
                            employee_code = table.find(".employee_code").val();
                            city = table.find(".city").val();
                            addr_sign_in = table.find(".addr_sign_in").val();
                            addr_detail = table.find(".addr_detail").val();
                            journalID = table.find(".journalID").val();
                            score=table.find(".score").val();
                            object=table.find(".object").val();
                            remark=table.find(".remark").val();
                            auditResult = table.find(".auditResult").val();

                            // call onObjectChange();
                            CameraScoreCard.onObjectChange(object);

                            // get scores
                            cheating = table.find('.cheating').val();
                            recSurrounding = table.find('.recSurrounding').val();
                            announceContract = table.find('.announceContract').val();
                            selfIntro = table.find('.selfIntro').val();
                            RPCEndRec = table.find('.RPCEndRec').val();
                            askOthers = table.find('.askOthers').val();
                            leaveMsg = table.find('.leaveMsg').val();
                            askForDebt = table.find('.askForDebt').val();
                            tellConsequence = table.find('.tellConsequence').val();
                            negotiatePay = table.find('.negotiatePay').val();
                            provideSolution = table.find('.provideSolution').val();
                            specificCollect = table.find('.specificCollect').val();
                            payHierarchy = table.find('.payHierarchy').val();
                            updateDT = table.find('.updateDT').val();
                            cashCollect = table.find('.cashCollect').val();
                            
                            cheatType=table.find('.cheatType').val();
                            noIntroAnno=table.find('.noIntroAnno').val();

                            // show the signIns

                            // VideoScoreCard.showSignIns(journal_creator, visit_date, contract_no);

                            // initialize values on the score board
                            $("#journalID").val(journalID);
                            $("#visit_result").text(visit_result);
                            $("#journal_creator").text(journal_creator);
                            $("#contract_no").text(contract_no);
                            $("#visit_date_card").text(visit_date);
                            $("#visit_time").text(visit_time);
                            $("#employee_code").text(employee_code);
                            $("#addr_detail").text("");
                            $("#city").text(city);
                            $("#validity").text(validity);
                            $("#score").text(score);
                            
                            $("#CREATE_TIME").text(CREATE_TIME);
                            $("#ENDING_TIME").text(ENDING_TIME);
                            $("#CNT_VIDEO_RECORDS").text(CNT_VIDEO_RECORDS);
                            $("#CNT_AUDIO_RECORDS").text(CNT_AUDIO_RECORDS);

                            // set score
                            $('#cheating').text(cheating);
                            $('#recSurrounding').text(recSurrounding);
                            $('#announceContract').text(announceContract);
                            $('#selfIntro').text(selfIntro);
                            $('#RPCEndRec').text(RPCEndRec);
                            $('#askOthers').text(askOthers);
                            $('#leaveMsg').text(leaveMsg);
                            $('#askForDebt').text(askForDebt);
                            $('#tellConsequence').text(tellConsequence);
                            $('#negotiatePay').text(negotiatePay);
                            $('#provideSolution').text(provideSolution);
                            $('#specificCollect').text(specificCollect);
                            $('#payHierarchy').text(payHierarchy);
                            $('#updateDT').text(updateDT);
                            $('#cashCollect').text(cashCollect);
                            
                            $('#cheatType').val(cheatType);
                            $('#noIntroAnno').val(noIntroAnno);
                            compound=noIntroAnno.split(",");
                            boxes=document.getElementsByName("noIntroAnnoTypes");                
                            for(i=0;i<boxes.length;i++){
                                boxes[i].checked=false;
                            }
                            for(i=0;i<compound.length;i++){
                                for(j=0;j<boxes.length;j++){
                                    if(boxes[j].value==compound[i]){
                                        boxes[j].checked=true;
                                    }
                                }
                            }

                            // initialize user input box
                            $("#object").val(object);
                            $("#remark").val(remark);
                            /*videoInfo = JSON.parse(videoInfo);
                            $(".videoInfoFrame").remove();
                            for (i = 0; i < videoInfo.length; i++) {
                                CameraScoreCard.addVideoInfo(videoInfo[i].name, videoInfo[i].duration, videoInfo[i].createDate, videoInfo[i].createTime, videoInfo[i].uploadDate,
                                        videoInfo[i].uploadTime);
                            }*/
                            $("#tips").text("");
                            if (action == "edit") {
                                $("#object").prop("disabled", false);
                                $("#remark").prop("disabled", false);
                                $("#scoreSubmitBtn").attr("onclick", "return CameraScore.update(" + id + ");");
                                $("#scoreSubmitBtn").text("保存");
                                $(".auditFrame").remove();
                            } else {
                                CameraScoreCard.showAuditHtml();
                                $(".auditDelBtn").remove();
                                if (auditResult != "blank") {
                                    // if the score has audited,show the audit result.
                                    CameraAudits.fillData(id);
                                    CameraScoreCard.showAuditDelBtn(id);
                                }
                                $("#object").prop("disabled", true);
                                $("#remark").prop("disabled", true);
                                $("#scoreSubmitBtn").attr("onclick", "return CameraAudits.Add(" + id + ");");
                                $("#scoreSubmitBtn").text("提交内审结果");
                            }
                        }
                    });

            $('#videoScoreBoard').on(
                    'show.bs.modal',
                    function (e) {

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

                            // VideoScoreCard.showSignIns(journal_creator, visit_date, contract_no);

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

                            // call onObjectChange();
                            VideoScoreCard.onObjectChange(object);

                            // get scores
                            cheating = table.find('.cheating').val();
                            recSurrounding = table.find('.recSurrounding').val();
                            announceContract = table.find('.announceContract').val();
                            selfIntro = table.find('.selfIntro').val();
                            RPCEndRec = table.find('.RPCEndRec').val();
                            askOthers = table.find('.askOthers').val();
                            leaveMsg = table.find('.leaveMsg').val();
                            askForDebt = table.find('.askForDebt').val();
                            tellConsequence = table.find('.tellConsequence').val();
                            negotiatePay = table.find('.negotiatePay').val();
                            provideSolution = table.find('.provideSolution').val();
                            specificCollect = table.find('.specificCollect').val();
                            payHierarchy = table.find('.payHierarchy').val();
                            updateDT = table.find('.updateDT').val();
                            cashCollect = table.find('.cashCollect').val();

                            // show the signIns

                            // VideoScoreCard.showSignIns(journal_creator, visit_date, contract_no);

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
                            $('#cheating').text(cheating);
                            $('#recSurrounding').text(recSurrounding);
                            $('#announceContract').text(announceContract);
                            $('#selfIntro').text(selfIntro);
                            $('#RPCEndRec').text(RPCEndRec);
                            $('#askOthers').text(askOthers);
                            $('#leaveMsg').text(leaveMsg);
                            $('#askForDebt').text(askForDebt);
                            $('#tellConsequence').text(tellConsequence);
                            $('#negotiatePay').text(negotiatePay);
                            $('#provideSolution').text(provideSolution);
                            $('#specificCollect').text(specificCollect);
                            $('#payHierarchy').text(payHierarchy);
                            $('#updateDT').text(updateDT);
                            $('#cashCollect').text(cashCollect);


                            // initialize user input box
                            $("#object").val(object);
                            $("#remark").val(remark);
                            videoInfo = JSON.parse(videoInfo);
                            $(".videoInfoFrame").remove();
                            for (i = 0; i < videoInfo.length; i++) {
                                VideoScoreCard.addVideoInfo(videoInfo[i].name, videoInfo[i].duration, videoInfo[i].createDate, videoInfo[i].createTime, videoInfo[i].uploadDate,
                                        videoInfo[i].uploadTime);
                            }
                            $("#tips").text("");
                            if (action == "edit") {
                                $("#object").prop("disabled", false);
                                $("#remark").prop("disabled", false);
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
                                $("#object").prop("disabled", true);
                                $("#remark").prop("disabled", true);
                                $("#scoreSubmitBtn").attr("onclick", "return VideoAudits.Add(" + id + ");");
                                $("#scoreSubmitBtn").text("提交内审结果");
                            }
                        }
                    });
        });