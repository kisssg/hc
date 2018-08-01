var VideoScore = {
    name : "",
    addScore : function() {
	alert("score added!");
	$("#videoScoreBoard").modal("hide");
    },
    deleteScore : function(id) {
	alert(id + " deleted!");
    },
    updateScore : function(id) {
	alert(id + " updated!");
    },
}