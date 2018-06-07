<?php
use Phalcon\Mvc\Model;
class SilentMonitorContracts extends Model {
	public function initialize() {
		$this->setSource ( "silent_monitor_contract" );
	}
	public $id;
	public $lcs;
	public $collector;
	public $region;
	public $batch;
	public $assigned_amt_group;
	public $evid_srv;
	public $name;
	public $debt_start;
	public $checking_date;
	public $qc_name;
	public $uploader;
	public $upload_time;
	public $assess_count;
	public $remark;	
}