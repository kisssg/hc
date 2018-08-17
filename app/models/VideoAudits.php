<?php
use Phalcon\Mvc\Model;
class VideoAudits extends Model{
	public $id;
	public $visitDate;
	public $visitTime;
	public $contractNo;
	public $result;
	public $remark;
	public $auditor;
	public $createDate;
	public $createTime;
	public $editDate;
	public $editTime;	
	public $vsID;
	
}