<?php
class VideoAuditController extends ControllerBase{
	public function initialize(){
		
	}
	public function addAction($auditor){
		$va=new VideoAudits;
		$va->auditor=$auditor;
		$va->save();
		echo $auditor." added!";
	}
	public function deleteAction(){
		
	}
	public function updateAction(){
		
	}
	public function showAction(){
		
	}
	
}