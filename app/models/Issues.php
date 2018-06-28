<?php
use Phalcon\Mvc\Model;
class Issues extends Model {
	public $id;
	public $date;
	public $contract_no;
	public $client_name;
	public $phone;
	public $object;
	public $city;
	public $region;
	public $collector;
	public $issue_type;
	public $issue;
	public $remark;
	public $responsible_person;
	public $feedback;
	public $qc_name;
	public $result;
	public $close_reason;
	public $callback_id;
	public $add_time;
	public $feedback_person;
	public $feedback_time;
	public $close_person;
	public $close_time;
	public $edit_log;
	public $source;
	public $harassment_type;
	public $upload_time;
	public $uploader;
	public function initialize() {
		$this->setSource ( "fc_issue" );
	}
}