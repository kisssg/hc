<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class JournalsController extends ControllerBase {
	public function initialize() {
		$this->tag->setTitle ( 'VRD Scoring' );
	}
	public function indexAction() {
	}
	public function searchAction() {
		$this->tag->appendTitle ( '|Journals Search' );
		$this->view->setTemplateBefore ( "vrd" );
		$numberPage = 1;
		if ($this->request->isPost ()) {
			$visit_date = $this->request->getPost ( 'visit_date', 'string' );
			$journal_creator = $this->request->getPost ( 'journal_creator', 'string' );
			$contract_no = $this->request->getPost ( 'contract_no', 'string' );
			$query = new Criteria ();
			$query->setModelName ( "Journals" );
			$query->where ( "1=1" );
			$hasRequest = false;
			if ($visit_date) {
				$query->andWhere ( "visit_date=:visit_date: ", [ 
						"visit_date" => "$visit_date" 
				] );
				$hasRequest = true;
			}
			if ($journal_creator) {
				$query->andWhere ( "journal_creator like :journal_creator:", [ 
						"journal_creator" => "$journal_creator%" 
				] );
				$hasRequest = true;
			}
			if ($contract_no) {
				$query->andWhere ( "contract_no = :contract_no:", [ 
						"contract_no" => "$contract_no" 
				] );
				$hasRequest = true;
			}
			// $query1 = Criteria::fromInput ( $this->di, "Journals", $this->request->getPost () );
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
		$journals = Journals::find ( $parameters );
		if (count ( $journals ) == 0) {
			$this->flash->notice ( "The search did not find any journals" );
		}
		
		$paginator = new Paginator ( array (
				"data" => $journals,
				"limit" => 10,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
	public function vrdScoreAddAction() {
		$this->view->disable ();
		try{
		$contractNo = $this->request->getPost ( 'contractNo' );
		$visitDate = $this->request->getPost ( 'visitDate' );
		$visitTime = $this->request->getPost ( 'visitTime' );
		$LLI = $this->request->getPost ( 'LLI' );
		$employeeID = $this->request->getPost ( 'employeeID' );
		$city = $this->request->getPost ( 'city' );
		$signInAddr = $this->request->getPost ( 'signInAddr' );
		$visitResult = $this->request->getPost ( 'visitResult' );
		$duration = $this->request->getPost ( 'duration' );
		$object = $this->request->getPost ( 'object' );
		$videoInfo = $this->request->getPost ( 'videoInfo' );
		$integrality = $this->request->getPost ( 'integrality' );
		$description = $this->request->getPost ( 'description' );
		$announcement = $this->request->getPost ( 'announcement' );
		$location = $this->request->getPost ( 'location' );
		$objectionHandling = $this->request->getPost ( 'objectionHandling' );
		$noHarassment = $this->request->getPost ( 'noHarassment' );
		$getPTP = $this->request->getPost ( 'getPTP' );
		$skipTrace = $this->request->getPost ( 'skipTrace' );
		$score = $this->request->getPost ( 'score' );
		$remark = $this->request->getPost ( 'remark' );
		$complaintIndicator = $this->request->getPost ( 'complaintIndicator' );
		$QC = $this->request->getPost ( 'QC' );
		$createTime = $this->request->getPost ( 'createTime' );
		$createDate = $this->request->getPost ( 'createDate' );
		$journalID = $this->request->getPost ( 'journalID' );
		$id = $this->request->getPost ( 'id' );
		
		if ($id == "") {
			$vrdScore = new VideoScores ();
		} else {
			$vrdScore = VideoScores::findFirst ( $id );
		}
		$vrdScore->contractNo = $contractNo;
		$vrdScore->visitDate = $visitDate;
		$vrdScore->visitTime = $visitTime;
		$vrdScore->LLI = $LLI;
		$vrdScore->employeeID = $employeeID;
		$vrdScore->city = $city;
		$vrdScore->signInAddr = $signInAddr;
		$vrdScore->visitResult = $visitResult;
		$vrdScore->duration = $duration;
		$vrdScore->object = $object;
		$vrdScore->videoInfo = $videoInfo;
		$vrdScore->integrality = $integrality;
		$vrdScore->description = $description;
		$vrdScore->announcement = $announcement;
		$vrdScore->location = $location;
		$vrdScore->objectionHandling = $objectionHandling;
		$vrdScore->noHarassment = $noHarassment;
		$vrdScore->getPTP = $getPTP;
		$vrdScore->skipTrace = $skipTrace;
		$vrdScore->score = $score;
		$vrdScore->remark = $remark;
		$vrdScore->complaintIndicator = $complaintIndicator;
		$vrdScore->QC = $QC;
		$vrdScore->createTime = date ( "H:i:s" );
		$vrdScore->createDate = date ( "Y-m-d" );
		$vrdScore->journalID = $journalID;
		
		if($vrdScore->save ()==true){
			echo '{"result":"success","msg":"'.$vrdScore->id.'"}';
		}else{
			throw new exception("failed transferring data");
		}
		}catch(Exception $e){
			echo '{"result":"failed","msg":"'.$e->getMessage().'"}';
		}
	}
	public function vrdScoreDelAction() {
		$this->view->disable ();
		try {
			$id = $this->request->getPost ( "id" );
			
			$score = VideoScores::find ( $id );
			if ($score == null) {
				throw new exception ( "数据不存在！" );
			}
			if ($score->delete () === true) {
				echo '{"result":"success","msg":"' . $id . '"}';
			} else {
				throw new exception ( "删除失败！请重试！" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function vrdScoresAction() {
		$this->tag->appendTitle ( '|Scores' );
		$this->view->setTemplateBefore ( "vrd" );
		$numberPage = 1;
		if ($this->request->isPost ()) {
			$visit_date = $this->request->getPost ( 'visit_date', 'string' );
			$journal_creator = $this->request->getPost ( 'journal_creator', 'string' );
			$contract_no = $this->request->getPost ( 'contract_no', 'string' );
			$query = new Criteria ();
			$query->setModelName ( "VideoScores" );
			$query->where ( "1=1" );
			$hasRequest = false;
			if ($visit_date) {
				$query->andWhere ( "visitDate=:visit_date: ", [ 
						"visit_date" => "$visit_date" 
				] );
				$hasRequest = true;
			}
			if ($journal_creator) {
				$query->andWhere ( "LLI like :journal_creator:", [ 
						"journal_creator" => "$journal_creator%" 
				] );
				$hasRequest = true;
			}
			if ($contract_no) {
				$query->andWhere ( "contractNo = :contract_no:", [ 
						"contract_no" => "$contract_no" 
				] );
				$hasRequest = true;
			}
			$this->persistent->mySearchParams = $query->getParams ();
		} else {
			$hasRequest = true;
			$numberPage = $this->request->getQuery ( "page", "int" );
		}
		
		$parameters = array ();
		if ($this->persistent->mySearchParams && $hasRequest) {
			$parameters = $this->persistent->mySearchParams;
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
		$journals = VideoScores::find ( $parameters );
		if (count ( $journals ) == 0) {
			$this->flash->notice ( "The search did not find any scores" );
		}
		
		$paginator = new Paginator ( array (
				"data" => $journals,
				"limit" => 10,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
}