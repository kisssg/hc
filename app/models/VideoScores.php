<?php
use Phalcon\Mvc\Model;
class VideoScores extends Model{
	public $id;
	public $contractNo;
	public $visitDate;
	public $visitTime;
	public $LLI;
	public $employeeID;
	public $city;
	public $signInAddr;
	public $visitResult;
	public $duration;
	public $object;
	public $videoName;
	public $videoInfo;
	public $integrality;
	public $description;
	public $announcement;
	public $location;
	public $objectionHandling;
	public $noHarassment;
	public $getPTP;
	public $skipTrace;
	public $score;
	public $remark;
	public $complaintIndicator;
	public $QC;
	public $createTime;
	public $createDate;
	public $journalID;	
}