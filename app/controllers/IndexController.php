<?php

class IndexController extends ControllerBase
{
	public function initialize(){
		$this->tag->setTitle("Home");
		parent::initialize();
	}
    public function indexAction()
    {
		
    }
    public function phpAction(){
    	phpinfo();
    }
}

