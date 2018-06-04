var Callback={
	delete:function(){
	    column=$("#column").val();
	    value=$("#value").val();
	    if(column==""|| value==""){
		alert("input value first");
		return;		
	    }
	    cf=confirm("确定删除"+$("#column").val()  + "为" + value + "的 所有未登记回访 的数据吗？");
	    if(cf==true){
		alert("function disabled");
		return;
	    URL = window.location.href;
		baseDir = URL.split("/")[3];
	    url="/" +baseDir+"/callback/markDeletion";
	    args={
		    "column_name":column,
		    "value":value
	    }
	    $("#btn_del").disable();
	    $.post(url,args,function(data){
		re=JSON.parse(data);
		alert(re.result+":" +re.msg);
		
	    })}
	},
	restore:function(action_id){
	    cf=confirm("确定要撤消这次转交操作吗？");
	    if(cf===true){
	    URL = window.location.href;
		baseDir = URL.split("/")[3];
		url="/" +baseDir+"/callback/restoreDeletion";
		args={
			"action_id":action_id
		}
		$.post(url,args,function(data){
		    re=JSON.parse(data);
		    alert(re.result + ":" + re.msg)
		    window.location.reload();
		});
	    }
	}
}