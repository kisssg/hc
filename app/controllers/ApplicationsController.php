<?php
class ApplicationsController extends ControllerBase{
	public function initialize(){
		
	}
	function applyAction(){
		$type=$this->request->getPost("type");
		$action=$this->request->getPost("action");
		$actID=$this->request->getPost("actID");
		$msg=$this->request->getPost("msg");
		$applicator=$this->request->getPost("applicator");
		$ap=new Applications;
		$ap->type=$type;
		$ap->action=$action;
		$ap->actID=$actID;
		$ap->msg=$msg;
		$ap->applicator=$applicator;		
	}
	function approveAction(){
		
	}
	function rejectAction(){
		
	}	
}