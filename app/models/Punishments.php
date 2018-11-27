<?php
use Phalcon\Mvc\Model;
class Punishments extends Model{
	public $id;
	public $violationId;
	public $collector;
	public $collectorCN;
	public $onBoardDate;
	public $employeeID;
	public $province;
	public $city;
	public $TL;
	public $issueFoundBy;
	public $reduction;
	public $levelOfAction;
	public $reductionType;
	
	public $createTime;
	public $createDate;
	public $editTime;
	public $editDate;
	public $editLog;
	public $creator;
	public $status;
}
