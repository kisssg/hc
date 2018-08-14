$(document)
        .ready(
                function () {
                    $.datetimepicker.setLocale('ch');
                    $(".datepicker").datetimepicker({
                        format : 'Y-m-d',
                        timepicker : false
                    });

                    $(".datetimepicker").datetimepicker({
                        format : 'Y-m-d H:i:s'
                    });

                    $('#videoScoreBoard')
                            .on(
                                    'show.bs.modal',
                                    function (e) {// initialize when
                                        // show the video
                                        // score board.
                                        var button = $(e.relatedTarget);
                                        var id = button.data("id");
                                        var action = button.data("action");
                                        var table = $("#" + id);
                                        if (action == "add") {
                                            // find text;
                                            visit_result = (table
                                                    .find('.visit_result_cn')
                                                    .text());
                                            journal_creator = table.find(
                                                    ".journal_creator").text();
                                            contract_no = table.find(
                                                    ".contract_no").text();
                                            visit_date = table.find(
                                                    ".visit_date").text();
                                            visit_time = table.find(
                                                    ".visit_time").text();
                                            validity = table.find(".validity")
                                                    .text();
                                            // find hidden values;
                                            employee_code = table.find(
                                                    ".employee_code").val();
                                            city = table.find(".city").val();
                                            addr_sign_in = table.find(
                                                    ".addr_sign_in").val();
                                            addr_detail = table.find(
                                                    ".addr_detail").val();
                                            journalID = table
                                                    .find(".journalID").val();

                                            /*
                                             * fetch sign-in data
                                             */
                                            VideoScoreCard.showSignIns(
                                                    journal_creator,
                                                    visit_date, contract_no);

                                            /*
                                             * initialize values on the score
                                             * board.
                                             */
                                            $("#journalID").val(journalID);
                                            $("#visit_result").text(
                                                    visit_result);
                                            $("#journal_creator").text(
                                                    journal_creator);
                                            $("#contract_no").text(contract_no);
                                            $("#visit_date_card").text(
                                                    visit_date);
                                            $("#visit_time").text(visit_time).css("color","black");
                                            $("#employee_code").text(
                                                    employee_code);
                                            $("#addr_sign_in").text(
                                                    addr_sign_in);
                                            $("#addr_detail").text(addr_detail).css("color","black");
                                            $("#city").text(city);
                                            $("#validity").text(validity);

                                            // initialize score
                                            $(".fif-value").val(15);
                                            $(".five-value").val(5);
                                            $("#score").text(100);
                                            $("#complaintIndicator").val("N");
                                            // initialize user input box
                                            $("#duration").val("");
                                            $("#object").val("");
                                            $("#videoName").val("");
                                            $("#remark").val("");
                                            $("#tips").text("");

                                            // initialize the html tag for video
                                            // info adding
                                            $(".videoInfoFrame").remove();
                                            $(".auditFrame").remove();
                                            VideoScoreCard.addVideoInfo();
                                        } else {
                                            // find text;
                                            visit_result = (table
                                                    .find('.visitResult')
                                                    .text());
                                            journal_creator = table
                                                    .find(".LLI").text();
                                            contract_no = table.find(
                                                    ".contractNo").text();
                                            visit_date = table.find(
                                                    ".visitDate").text();
                                            visit_time = table.find(
                                                    ".visitTime").text();
                                            validity = "无";
                                            score = table.find(".score").text();
                                            // find hidden values;
                                            employee_code = table.find(
                                                    ".employeeID").val();
                                            city = table.find(".city").val();
                                            signInAddr = table.find(
                                                    ".signInAddr").val();
                                            journalID = table
                                                    .find(".journalID").val();
                                            object = table.find(".object")
                                                    .val();
                                            remark = table.find(".remark")
                                                    .val();
                                            videoInfo = table
                                                    .find(".videoInfo").val();

                                            // get scores
                                            integrality = table.find(
                                                    '.integrality').val();
                                            description = table.find(
                                                    '.description').val();
                                            announcement = table.find(
                                                    '.announcement').val();
                                            scoreLocation = table.find(
                                                    '.location').val();
                                            objectionHandling = table.find(
                                                    '.objectionHandling').val();
                                            noHarassment = table.find(
                                                    '.noHarassment').val();
                                            getPTP = table.find('.getPTP')
                                                    .val();
                                            skipTrace = table
                                                    .find('.skipTrace').val();
                                            complaintIndicator = table.find(
                                                    ".complaintIndicator")
                                                    .val();
                                            /*
                                             * show the signIns
                                             */
                                            VideoScoreCard.showSignIns(
                                                    journal_creator,
                                                    visit_date, contract_no);

                                            // initialize values on the score
                                            // board
                                            $("#journalID").val(journalID);
                                            $("#visit_result").text(
                                                    visit_result);
                                            $("#journal_creator").text(
                                                    journal_creator);
                                            $("#contract_no").text(contract_no);
                                            $("#visit_date_card").text(
                                                    visit_date);
                                            $("#visit_time").text(visit_time);
                                            $("#employee_code").text(
                                                    employee_code);
                                            $("#addr_detail").text(signInAddr);
                                            $("#city").text(city);
                                            $("#validity").text(validity);
                                            $("#score").text(score);

                                            // set score
                                            $('#integrality').val(integrality);
                                            $('#description').val(description);
                                            $('#announcement')
                                                    .val(announcement);
                                            $('#location').val(scoreLocation);
                                            $('#objectionHandling').val(
                                                    objectionHandling);
                                            $('#noHarassment')
                                                    .val(noHarassment);
                                            $('#getPTP').val(getPTP);
                                            $('#skipTrace').val(skipTrace);
                                            $('#complaintIndicator').val(
                                                    complaintIndicator);
                                            // initialize user input box
                                            $("#object").val(object);
                                            $("#remark").val(remark);
                                            videoInfo = JSON.parse(videoInfo);
                                            $(".videoInfoFrame").remove();
                                            for (i = 0; i < videoInfo.length; i++) {
                                                VideoScoreCard.addVideoInfo(
                                                        videoInfo[i].name,
                                                        videoInfo[i].duration);
                                            }
                                            $("#tips").text("");
                                            if (action == "edit") {
                                                $("#object").attr("disabled",
                                                        false);
                                                $("#complaintIndicator").attr(
                                                        "disabled", false);
                                                $(".videoScore").attr(
                                                        "disabled", false);
                                                $(".videoName").attr(
                                                        "disabled", false);
                                                $(".duration").attr("disabled",
                                                        false);
                                                $("#remark").prop("disabled",
                                                        false);
                                                $("#scoreSubmitBtn").attr(
                                                        "onclick",
                                                        "return VideoScore.update("
                                                                + id + ");");
                                                $("#scoreSubmitBtn").text("保存");
                                                $(".auditFrame").remove();
                                            } else {
                                                var auditHtml = '<tr class="auditFrame"><td colspan="3"><div class="row">'
                                                        + '<div class="col-md-7">Audit Result:</div>'
                                                        + '<div class="col-xs-2">'
                                                        + '<select class="form-control input-sm" id="auditResult">'
                                                        + '<option>N</option><option>Y</option>'
                                                        + '</select></div></div></td></tr>'
                                                        + '<tr class="auditFrame"><td colspan="3"><div class="form-group">'
                                                        + '<label for="auditRemark" class="col-sm-2 control-label">备注：</label>'
                                                        + '<div class="col-sm-10">'
                                                        + '<textarea class="form-control" id="auditRemark" rows="5" onkeyup="" maxlength="500" placeholder="auditRemark"></textarea>'
                                                        + '</div></div></td></tr>';
                                                $(".auditFrame").remove();
                                                $("#tableBottom").after(
                                                        auditHtml);

                                                $("#object").attr("disabled",
                                                        true);
                                                $("#complaintIndicator").attr(
                                                        "disabled", true);
                                                $(".videoScore").attr(
                                                        "disabled", true);
                                                $(".videoName").attr(
                                                        "disabled", true);
                                                $(".duration").attr("disabled",
                                                        true);
                                                $("#remark").prop("disabled",
                                                        true);
                                                $("#scoreSubmitBtn").attr(
                                                        "onclick", "");
                                                $("#scoreSubmitBtn").text(
                                                        "balabala");
                                            }
                                        }
                                    });

                    $(".videoScore").change(function () {
                        /*
                         * update total score when item score change
                         */
                        scoreArr = $(".videoScore")
                        var totalScore = 0;
                        for (i = 0; i < scoreArr.length; i++) {
                            totalScore += Number(scoreArr[i].value);
                        }
                        $("#score").text(totalScore);
                    });

                });