<?php

class IndexController extends ControllerBase
{
	public function initialize(){
		$this->tag->setTitle("Home");
		parent::initialize();
	}
    public function indexAction()
    {
    	header('Location: /');
    }
    public function phpAction(){
    	phpinfo();
    }
}

