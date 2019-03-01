<?php
use Phalcon\Mvc\Model;
class CameraScores extends Model{
	public function initialize(){
		$this->setSource("fc_camera_scores");
	}
	public $SKP_CLIENT;
	public $ID_CUID;
	public $TEXT_CONTRACT_NUMBER;
	public $NAME_COLLECTOR;
	public $ID_EMPLOYEE;
	public $CODE_EQUIPMENT;
	public $STATUS_EQUIPMENT;
	public $DATE_ASSIGNMENT;
	public $SH_CITY;
	public $SV_NAME;
	public $TL_NAME;
	public $MGR_NAME;
	public $ACTION_DATE;
	public $ACTION_TIME;
	public $VISIT_RESULT;
	public $FLAG_WITH_VIDIO;
	public $FLAG_WITH_AUDIO;
	public $FLAG_WITH_ANY;
	public $FLAG_WITH_BOTH;
	public $CREATE_TIME;
	public $ENDING_TIME;
	public $SUM_VIDIO_TIME_DURATION;
	public $SUM_AUDIO_TIME_DURATION;
	public $CNT_VIDEO_RECORDS;
	public $CNT_AUDIO_RECORDS;
	public $ROW_ACTION;
	public $SHORT_TIME_VIDEO;
	public $LONG_TIME_VIDEO;
	public $SHORT_TIME_AUDIO;
	public $LONG_TIME_AUDIO;
	public $UNUSUAL_TIME_CREATION;
	public $FLAG_COLLECTED_LCS;
	public $object;
	public $score;
	public $remark;
	public $QC;
	public $QSCcreateTime;
	public $QSCcreateDate;
	public $QSCeditDate;
	public $QSCeditTime;
	public $cheating;
	public $recSurrounding;
	public $announceContract;
	public $selfIntro;
	public $RPCEndRec;
	public $askOthers;
	public $leaveMsg;
	public $askForDebt;
	public $tellConsequence;
	public $negotiatePay;
	public $provideSolution;
	public $specificCollect;
	public $payHierarchy;
	public $updateDT;
	public $cashCollect;
	public $cheatType;
	public $noIntroAnno;
	public $auditResult;
	public $week;
	public $status;
	public $authority;
	public $editLog;
	public $uploadTime;
	public $issueAdded;
	function grant($auth){
		$this->authority=$auth;
		return $this->save();
	}
	
}