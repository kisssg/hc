<?php
use Phalcon\Mvc\Model;

class WorkStatus extends Model{
	public $id;
	public $qc;
	public $work;
	public $batch;
	public $status;
	public $createtime;
	public $donetime;
	public $remark;
	public $grantDeadLine;
	public $grantHistory;
	public function initialize()
	{
		$this->setSource("workstatus");
	}
}