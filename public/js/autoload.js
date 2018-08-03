$(document).ready(function() {
    $.datetimepicker.setLocale('ch');
    $(".datepicker").datetimepicker({
	format : 'Y-m-d',
	timepicker : false
    });

    $(".datetimepicker").datetimepicker({
	format : 'Y-m-d H:i:s'
    });
    
    $('#videoScoreBoard').on('show.bs.modal', function(e) {//initialize when show the video score board.
	var button = $(e.relatedTarget);
	var id=button.data("id");
	var table = $("#" + id)
	//find text;
	visit_result = (table.find('.visit_result_cn').text());
	journal_creator=table.find(".journal_creator").text();
	contract_no=table.find(".contract_no").text();
	visit_date=table.find(".visit_date").text();
	visit_time=table.find(".visit_time").text();
	validity=table.find(".validity").text();
	//find hidden values;
	employee_code=table.find(".employee_code").val();
	city=table.find(".city").val();
	addr_sign_in=table.find(".addr_sign_in").val();
	addr_detail=table.find(".addr_detail").val();
	journalID=table.find(".journalID").val();
	//initialize values on the score board
	$("#journalID").val(journalID);
	$("#visit_result").text(visit_result);
	$("#journal_creator").text(journal_creator);
	$("#contract_no").text(contract_no);
	$("#visit_date_card").text(visit_date);
	$("#visit_time").text(visit_time);
	$("#employee_code").text(employee_code);
	$("#addr_sign_in").text(addr_sign_in);
	$("#addr_detail").text(addr_detail);
	$("#city").text(city);
	$("#validity").text(validity);
	
	//initialize score
	$(".fif-value").val(15);
	$(".five-value").val(5);
	$("#score").text(100);
	$("#complaintIndicator").val("N");
	//initialize user input box
	$("#duration").val("");
	$("#object").val("");
	$("#videoName").val("");
	$("#remark").val("");
	$("#tips").text("");
	
	//initialize the html tag for video info adding
	$(".videoInfo").remove();
	VideoScoreCard.addVideoInfo();
    });
    
    $(".videoScore").change(function(){//update total score when item score change
	scoreArr=$(".videoScore")
	var totalScore=0;
	for(i=0;i<scoreArr.length;i++){
	    totalScore += Number(scoreArr[i].value);
	}
	$("#score").text(totalScore);
    });

});