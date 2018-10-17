<?php
use Phalcon\Mvc\Model;
class CheckIns extends Model {
	public function initialize() {
		$this->setSource ( "sign_in_data" );
	}
	public $sign_id;
	public $llc;
	public $employee_id;
	public $sign_in_date;
	public $sign_in_time;
	public $addr;
	public $addr_detail;
	public $remark;
	public $device;
	public $pic;
	public $lon;
	public $lat;
	public $ip;
}