<?php

class IndexController extends ControllerBase
{
	protected function initialize(){
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

