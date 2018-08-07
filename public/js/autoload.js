$(document)
	.ready(
		function() {
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
				    function(e) {// initialize when
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
					    $("#addr_sign_in").text(
						    addr_sign_in);
					    $("#addr_detail").text(addr_detail);
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
					    $(".videoInfo").remove();
					    VideoScoreCard.addVideoInfo();
					} else {
					    alert("未完成的功能");
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
					    videoInfo=table.find(".videoInfo").val();

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
					    $("#signInAddr").text(signInAddr);
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
					    vInfo=VideoScore.videoInfoSplit(videoInfo);
					    $("#remark").val(vInfo);
					    //$("#remark").val(remark);
					    $("#tips").text("");
					    if (action == "edit") {
						$("#object").attr("disabled",
							false);
						$("#complaintIndicator").attr(
							"disabled", false);
						$(".videoScore").attr(
							"disabled", false);
						$("#remark").prop("disabled",
							false);
						$("#scoreSubmitBtn").attr(
							"onclick",
							"return VideoScore.update("
								+ id + ");");
						$("#scoreSubmitBtn").text("保存");
					    } else {
						$("#object").attr("disabled",
							true);
						$("#complaintIndicator").attr(
							"disabled", true);
						$(".videoScore").attr(
							"disabled", true);
						$("#remark").prop("disabled",
							true);
						$("#scoreSubmitBtn").attr(
							"onclick", "");
						$("#scoreSubmitBtn").text(
							"balabala");
					    }
					}
				    });

		    $(".videoScore").change(function() {// update total score
							// when item score
			// change
			scoreArr = $(".videoScore")
			var totalScore = 0;
			for (i = 0; i < scoreArr.length; i++) {
			    totalScore += Number(scoreArr[i].value);
			}
			$("#score").text(totalScore);
		    });

		});