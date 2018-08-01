$(document).ready(function() {
    $.datetimepicker.setLocale('ch');
    $(".datepicker").datetimepicker({
	format : 'Y-m-d',
	timepicker : false
    });

    $(".datetimepicker").datetimepicker({
	format : 'Y-m-d H:i:s'
    });
    
    $('#videoScoreBoard').on('show.bs.modal', function(e) {
	var button = $(e.relatedTarget);
	var id=button.data("id");
	var table = $("#" + id)
	//find text;
	visit_result = (table.find('.visit_result_cn').text());
	journal_creator=table.find(".journal_creator").text();
	contract_no=table.find(".contract_no").text();
	visit_date=table.find(".visit_date").text();
	visit_time=table.find(".visit_time").text();	
	//find hidden values;
	//employee_code=table.find(".employee_code").val();
	//city=table.find(".city").val();
	//initialize values on the score board
	$("#visit_result").text(visit_result);
	$("#journal_creator").text(journal_creator);
	$("#contract_no").text(contract_no);
	$("#visit_date_card").text(visit_date);
	$("#visit_time").text(visit_time);
	//$("#employee_code").text(employee_code);
    });

});