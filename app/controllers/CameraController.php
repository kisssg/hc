<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class CameraController extends ControllerBase {
	public function initialize() {
		$this->tag->setTitle ( "Camera Scoring" );
	}
	public function searchAction() {
		$this->tag->appendTitle ( '| Search Records' );
		// $this->view->setTemplateBefore ( "camera" );
		$numberPage = 1;
		if ($this->request->isPost ()) {
			$visit_date = $this->request->getPost ( 'visit_date', 'string' );
			$journal_creator = $this->request->getPost ( 'journal_creator', 'string' );
			$contract_no = $this->request->getPost ( 'contract_no', 'string' );
			$QC=$this->request->getPost('QC');
			$query = new Criteria ();
			$query->setModelName ( "CameraScores" );
			$query->where ( "status='ok'" );
			$query->orderBy ( "NAME_COLLECTOR,ACTION_DATE,TEXT_CONTRACT_NUMBER" );
			$hasRequest = false;
			if ($visit_date) {
				$query->andWhere ( "ACTION_DATE=:visit_date: ", [ 
						"visit_date" => "$visit_date" 
				] );
				$hasRequest = true;
			}
			if ($journal_creator) {
				$query->andWhere ( "NAME_COLLECTOR = :journal_creator: ", [
						"journal_creator" => "$journal_creator"
				] );
				$hasRequest = true;
			}
			if ($QC) {
				$query->andWhere ( "QC = :QC: ", [
						"QC" => "$QC"
				] );
				$hasRequest = true;
			}
			if ($contract_no) {
				$query->andWhere ( "TEXT_CONTRACT_NUMBER = :contract_no:", [ 
						"contract_no" => "$contract_no" 
				] );
				$hasRequest = true;
			}
			$this->persistent->searchParams = $query->getParams ();
		} else {
			$hasRequest = true;
			$numberPage = $this->request->getQuery ( "page", "int" );
		}
		
		$parameters = array ();
		if ($this->persistent->searchParams && $hasRequest) {
			$parameters = $this->persistent->searchParams;
		} else {
			$parameters = [ 
					"conditions" => "1=2" 
			];
		}
		if ($parameters ['conditions'] == "1=1") {
			$parameters = [ 
					"conditions" => "1=2" 
			];
		}
		$journals = CameraScores::find ( $parameters );
		if (count ( $journals ) == 0) {
			$this->flash->notice ( "The search did not find any journals" );
		}
		
		$paginator = new Paginator ( array (
				"data" => $journals,
				"limit" => 50,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
	public function scoreSaveAction() {
		$this->view->disable ();
		
		try {
			$id = $this->request->getPost ( "journalID" );
			$submitQC = trim ( $this->session->get ( 'auth' ) ['name'] );
			
			$object = $this->request->getPost ( 'object' );
			$score = $this->request->getPost ( 'score' );
			$remark = $this->request->getPost ( 'remark' );
			$cheating = $this->request->getPost ( 'cheating' );
			$recSurrounding = $this->request->getPost ( 'recSurrounding' );
			$announceContract = $this->request->getPost ( 'announceContract' );
			$selfIntro = $this->request->getPost ( 'selfIntro' );
			$RPCEndRec = $this->request->getPost ( 'RPCEndRec' );
			$askOthers = $this->request->getPost ( 'askOthers' );
			$leaveMsg = $this->request->getPost ( 'leaveMsg' );
			$askForDebt = $this->request->getPost ( 'askForDebt' );
			$tellConsequence = $this->request->getPost ( 'tellConsequence' );
			$negotiatePay = $this->request->getPost ( 'negotiatePay' );
			$provideSolution = $this->request->getPost ( 'provideSolution' );
			$specificCollect = $this->request->getPost ( 'specificCollect' );
			$payHierarchy = $this->request->getPost ( 'payHierarchy' );
			$updateDT = $this->request->getPost ( 'updateDT' );
			$cashCollect = $this->request->getPost ( 'cashCollect' );
			// $week=$this->request->getPost('week');
			$camera = CameraScores::findFirst ( $id );
			$camera->object = $object;
			$camera->score = $score;
			$camera->remark = $remark;
			$camera->cheating = $cheating;
			$camera->recSurrounding = $recSurrounding;
			$camera->announceContract = $announceContract;
			$camera->selfIntro = $selfIntro;
			$camera->RPCEndRec = $RPCEndRec;
			$camera->askOthers = $askOthers;
			$camera->leaveMsg = $leaveMsg;
			$camera->askForDebt = $askForDebt;
			$camera->tellConsequence = $tellConsequence;
			$camera->negotiatePay = $negotiatePay;
			$camera->provideSolution = $provideSolution;
			$camera->specificCollect = $specificCollect;
			$camera->payHierarchy = $payHierarchy;
			$camera->updateDT = $updateDT;
			$camera->cashCollect = $cashCollect;
			if (date ( "W", strtotime ( $camera->ACTION_DATE ) ) == 0) {
				$difday=-6;
			} else {
				$date = date_create ( $camera->ACTION_DATE);
				$difday=1-date ( "w", strtotime ( $camera->ACTION_DATE ) );
				date_add ( $date, date_interval_create_from_date_string ( $difday.' days' ) );
				$week =  date_format ( $date, 'Y-m-d' );
			}
			$camera->week=$week;
			if($camera->QC == ""){
				$camera->QSCcreateDate = date ( "Y-m-d" );
				$camera->QSCcreateTime = date ( "H:i:s" );
			}else{				
				$camera->QSCeditDate = date ( "Y-m-d" );
				$camera->QSCeditTime = date ( "H:i:s" );
			}
			
			
			if ($camera->QC != $submitQC && $camera->QC != "") {
				throw new exception ( "你只能修改自己的数据，这条数据属于" . $camera->QC );
			}
			
			$camera->QC = $submitQC;
			if ($camera->save () == true) {
				echo '{"result":"success","msg":"' . $id . '"}';
			} else {
				throw new exception ( "Failed updating data" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function batchManageAction(){
		
	}
}