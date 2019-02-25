<?php
use Phalcon\Mvc\Model;
class Applications extends Model{
	public $id;
	public $type;
	public $action;
	public $actID;
	public $msg;
	public $createDate;
	public $createTime;
	public $endDate;
	public $endTime;
	public $applicator;
	public $approver;
	public $status;
	public function reject(){
		$this->status ='rejected';
		return $this->save();
	}
}