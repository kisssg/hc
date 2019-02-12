<?php
use Phalcon\Mvc\Model;
class Applications extends Model{
	public $id;
	public $type;
	public $action;
	public $actID;
	public $msg;
	public $applyDate;
	public $applyTime;
	public $approveDate;
	public $approveTime;
	public $applicator;
	public $approver;	
}