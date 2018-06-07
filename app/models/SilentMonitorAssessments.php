<?php
use Phalcon\Mvc\Model;
class SilentMonitorAssessments extends Model {
	public function initialize() {
		$this->setSource ( "silent_monitor_assessment" );
	}
	public $id;
	public $Checking_Date;
	public $LCS;
	public $Agency;
	public $Region;
	public $Contract_no;
	public $Call_date;
	public $Duration;
	public $seconds;
	public $Case_object;
	public $Expression;
	public $Understanding;
	public $Confirm_valid_information;
	public $Objection_Handling;
	public $Get_PTP;
	public $Language_attack;
	public $Intimidate_Provocate;
	public $provocation;
	public $Intimidation;
	public $Self_introduction;
	public $Correct_Information;
	public $Information_leakage;
	public $Call_Records_System_memo;
	public $Effective_Communication;
	public $Complaint_Inclination;
	public $Score;
	public $Backup;
	public $QC;
	public $create_time;
	public $contract_id;
}