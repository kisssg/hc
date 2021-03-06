<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class JournalsController extends ControllerBase {
	public function initialize() {
		$this->tag->setTitle ( 'VRD Scoring' );
	}
	public function indexAction() {
		$this->response->redirect ( 'journals/search' );
		$this->view->disable ();
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
			$query->orderBy("journal_creator,contract_no");
			$hasRequest = false;
			if ($visit_date) {
				$query->andWhere ( "visit_date=:visit_date: ", [ 
						"visit_date" => "$visit_date" 
				] );
				$hasRequest = true;
			}
			if ($journal_creator) {
				$query->andWhere ( "journal_creator = :journal_creator: or name_cn = :journal_creator:", [ 
						"journal_creator" => "$journal_creator" 
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
				"limit" => 50,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
	public function vrdScoreAddOldAction() {
		$this->view->disable ();
		try {
			$QC = trim($this->session->get ( 'auth' ) ['name']);
			if ($QC == "") {
				throw new exception ( "Login session expired!" );
			}
			$id = $this->request->getPost ( 'id' );
			$videoInfo = $this->request->getPost ( 'videoInfo' );
			$city = $this->request->getPost ( 'city' );
			$LLI = $this->request->getPost ( 'LLI' );
			$contractNo = $this->request->getPost ( 'contractNo' );
			$visitDate = $this->request->getPost ( 'visitDate' );
			$visitTime = $this->request->getPost ( 'visitTime' );
			$employeeID = $this->request->getPost ( 'employeeID' );
			$signInAddr = $this->request->getPost ( 'signInAddr' );
			$visitResult = $this->request->getPost ( 'visitResult' );
			$negotiator = $this->request->getPost ( 'negotiator' );
			$object = $this->request->getPost ( 'object' );
			$announceRec = $this->request->getPost ( 'announceRec' );
			$visitLocation = $this->request->getPost ( 'visitLocation' );
			$objectionHandling = $this->request->getPost ( 'objectionHandling' );
			$InfoInvestigation = $this->request->getPost ( 'InfoInvestigation' );
			$score = $this->request->getPost ( 'score' );
			$matchedVisitResult = $this->request->getPost ( 'matchedVisitResult' );
			$uploadOntime = $this->request->getPost ( 'uploadOntime' );
			$IDVerification = $this->request->getPost ( 'IDVerification' );
			$selfIntroduction = $this->request->getPost ( 'selfIntroduction' );
			$infoProviding = $this->request->getPost ( 'infoProviding' );
			$paymentChannel = $this->request->getPost ( 'paymentChannel' );
			$approvedCashCollect = $this->request->getPost ( 'approvedCashCollect' );
			$dataIntegrality = $this->request->getPost ( 'dataIntegrality' );
			$wrongInfo = $this->request->getPost ( 'wrongInfo' );
			$attitude = $this->request->getPost ( 'attitude' );
			$cheating = $this->request->getPost ( 'cheating' );
			$informationLeakage = $this->request->getPost ( 'informationLeakage' );
			$urgentNoReport = $this->request->getPost ( 'urgentNoReport' );
			$acceptWaiving = $this->request->getPost ( 'acceptWaiving' );
			$sensitiveWording = $this->request->getPost ( 'sensitiveWording' );
			$duration = $this->request->getPost ( 'duration' );
			$description = $this->request->getPost ( 'description' );
			$remark = $this->request->getPost ( 'remark' );
			$score = $this->request->getPost ( 'score' );
			$journalID = $this->request->getPost ( 'journalID' );
			$videoCreateDate = $this->request->getPost ( 'videoCreateDate' );
			$videoCreateTime = $this->request->getPost ( 'videoCreateTime' );
			$videoUploadDate = $this->request->getPost ( 'videoUploadDate' );
			$videoUploadTime = $this->request->getPost ( 'videoUploadTime' );
			
			if ($id == "") {
				$vrdScore = new VideoScores ();
				$vrdScore->createTime = date ( "H:i:s" );
				$vrdScore->createDate = date ( "Y-m-d" );
				$vrdScore->QC = $QC;
				$vrdScore->journalID = $journalID;
			} else {
				$vrdScore = VideoScores::findFirst ( $id );
				if ($vrdScore == null) {
					throw new exception ( "数据不存在！" );
				}
				if (strtolower($QC) != strtolower($vrdScore->QC)) {
					throw new Exception ( "你只能修改自己的数据。".$vrdScore->QC);
				}
				$vrdScore->editTime = date ( "H:i:s" );
				$vrdScore->editDate = date ( "Y-m-d" );
			}
			
			$vrdScore->videoInfo = $videoInfo;
			$vrdScore->city = $city;
			$vrdScore->LLI = $LLI;
			$vrdScore->contractNo = $contractNo;
			$vrdScore->visitDate = $visitDate;
			$vrdScore->visitTime = $visitTime;
			$vrdScore->employeeID = $employeeID;
			$vrdScore->signInAddr = $signInAddr;
			$vrdScore->visitResult = $visitResult;
			$vrdScore->negotiator = $negotiator;
			$vrdScore->object = $object;
			$vrdScore->announceRec = $announceRec;
			$vrdScore->visitLocation = $visitLocation;
			$vrdScore->objectionHandling = $objectionHandling;
			$vrdScore->InfoInvestigation = $InfoInvestigation;
			$vrdScore->score = $score;
			$vrdScore->matchedVisitResult = $matchedVisitResult;
			$vrdScore->uploadOntime = $uploadOntime;
			$vrdScore->IDVerification = $IDVerification;
			$vrdScore->selfIntroduction = $selfIntroduction;
			$vrdScore->infoProviding = $infoProviding;
			$vrdScore->paymentChannel = $paymentChannel;
			$vrdScore->approvedCashCollect = $approvedCashCollect;
			$vrdScore->dataIntegrality = $dataIntegrality;
			$vrdScore->wrongInfo = $wrongInfo;
			$vrdScore->attitude = $attitude;
			$vrdScore->cheating = $cheating;
			$vrdScore->informationLeakage = $informationLeakage;
			$vrdScore->urgentNoReport = $urgentNoReport;
			$vrdScore->acceptWaiving = $acceptWaiving;
			$vrdScore->sensitiveWording = $sensitiveWording;
			$vrdScore->duration = $duration;
			$vrdScore->description = $description;
			$vrdScore->remark = $remark;
			$vrdScore->score = $score;
			
			$vrdScore->videoCreateDate=$videoCreateDate;
			$vrdScore->videoCreateTime=$videoCreateTime;
			$vrdScore->videoUploadDate=$videoUploadDate;
			$vrdScore->videoUploadTime=$videoUploadTime;
			
			
			if ($vrdScore->save () == true) {
				echo '{"result":"success","msg":"' . $vrdScore->id . '"}';
				/*
				 * update count of vrdChecked in journals
				 */
				$scores=VideoScores::findByJournalID($journalID);
				$journal=Journals::findFirst($journalID);
				$journal->vrdChecked=$scores->count();
				$journal->save();
			} else {
				throw new exception ( "failed transferring data" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function vrdScoreAddAction(){
		$this->view->disable ();
		try {
			$QC = trim($this->session->get ( 'auth' ) ['name']);
			if ($QC == "") {
				throw new exception ( "Login session expired!" );
			}
			$id = $this->request->getPost ( 'id' );
			$videoInfo = $this->request->getPost ( 'videoInfo' );
			$city = $this->request->getPost ( 'city' );
			$LLI = $this->request->getPost ( 'LLI' );
			$contractNo = $this->request->getPost ( 'contractNo' );
			$visitDate = $this->request->getPost ( 'visitDate' );
			$visitTime = $this->request->getPost ( 'visitTime' );
			$employeeID = $this->request->getPost ( 'employeeID' );
			$signInAddr = $this->request->getPost ( 'signInAddr' );
			$visitResult = $this->request->getPost ( 'visitResult' );
			$negotiator = $this->request->getPost ( 'negotiator' );
			$object = $this->request->getPost ( 'object' );
			$duration = $this->request->getPost ( 'duration' );
			
			//score items * 15
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
			
			$remark = $this->request->getPost ( 'remark' );
			$score = $this->request->getPost ( 'score' );
			$journalID = $this->request->getPost ( 'journalID' );
			$videoCreateDate = $this->request->getPost ( 'videoCreateDate' );
			$videoCreateTime = $this->request->getPost ( 'videoCreateTime' );
			$videoUploadDate = $this->request->getPost ( 'videoUploadDate' );
			$videoUploadTime = $this->request->getPost ( 'videoUploadTime' );
			
			if ($id == "") {
				$vrdScore = new NewVideoScores ();
				$vrdScore->createTime = date ( "H:i:s" );
				$vrdScore->createDate = date ( "Y-m-d" );
				$vrdScore->QC = $QC;
				$vrdScore->journalID = $journalID;
			} else {
				$vrdScore = NewVideoScores::findFirst ( $id );
				if ($vrdScore == null) {
					throw new exception ( "数据不存在！" );
				}
				if (strtolower($QC) != strtolower($vrdScore->QC)) {
					throw new Exception ( "你只能修改自己的数据。".$vrdScore->QC);
				}
				$vrdScore->editTime = date ( "H:i:s" );
				$vrdScore->editDate = date ( "Y-m-d" );
			}
			
			$vrdScore->videoInfo = $videoInfo;
			$vrdScore->city = $city;
			$vrdScore->LLI = $LLI;
			$vrdScore->contractNo = $contractNo;
			$vrdScore->visitDate = $visitDate;
			$vrdScore->visitTime = $visitTime;
			$vrdScore->employeeID = $employeeID;
			$vrdScore->signInAddr = $signInAddr;
			$vrdScore->visitResult = $visitResult;
			$vrdScore->negotiator = $negotiator;
			$vrdScore->object = $object;
			
			//score items * 15
			$vrdScore->cheating = $cheating;
			$vrdScore->recSurrounding = $recSurrounding;
			$vrdScore->announceContract = $announceContract;
			$vrdScore->selfIntro = $selfIntro;
			$vrdScore->RPCEndRec = $RPCEndRec;
			$vrdScore->askOthers = $askOthers;
			$vrdScore->leaveMsg = $leaveMsg;
			$vrdScore->askForDebt = $askForDebt;
			$vrdScore->tellConsequence = $tellConsequence;
			$vrdScore->negotiatePay = $negotiatePay;
			$vrdScore->provideSolution = $provideSolution;
			$vrdScore->specificCollect = $specificCollect;
			$vrdScore->payHierarchy = $payHierarchy;
			$vrdScore->updateDT = $updateDT;
			$vrdScore->cashCollect = $cashCollect;			
			
			$vrdScore->duration = $duration;
			$vrdScore->remark = $remark;
			$vrdScore->score = $score;
			
			$vrdScore->videoCreateDate=$videoCreateDate;
			$vrdScore->videoCreateTime=$videoCreateTime;
			$vrdScore->videoUploadDate=$videoUploadDate;
			$vrdScore->videoUploadTime=$videoUploadTime;
			
			
			if ($vrdScore->save () == true) {
				echo '{"result":"success","msg":"' . $vrdScore->id . '"}';
				/*
				 * update count of vrdChecked in journals
				 */
				$scores=NewVideoScores::findByJournalID($journalID);
				$journal=Journals::findFirst($journalID);
				$journal->vrdChecked=$scores->count();
				$journal->save();
			} else {
				throw new exception ( "failed transferring data" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function vrdScoreDelOldAction() {
		$this->view->disable ();
		try {
			$QC = $this->session->get ( 'auth' ) ['name'];
			$id = $this->request->getPost ( "id" );
			
			if ($QC == "") {
				throw new exception ( "Login session expired!" );
			}
			
			$score = VideoScores::findFirst ( $id );
			$journalID=$score->journalID;
			if ($score == null) {
				throw new exception ( "数据不存在！" );
			}
			if (strtolower($QC) != strtolower($score->QC)) {
				throw new Exception ( "你只能修改自己的数据。" );
			}
			if ($score->delete () === true) {
				echo '{"result":"success","msg":"' . $id . '"}';
				/*
				 * update count of vrdChecked in journals
				 */
				$scores=VideoScores::findByJournalID($journalID);
				$journal=Journals::findFirst($journalID);
				$journal->vrdChecked=$scores->count();
				$journal->save();
			} else {
				throw new exception ( "删除失败！请重试！" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function vrdScoreDelAction(){
		$this->view->disable ();
		try {
			$QC = $this->session->get ( 'auth' ) ['name'];
			$id = $this->request->getPost ( "id" );
			
			if ($QC == "") {
				throw new exception ( "Login session expired!" );
			}
			
			$score = NewVideoScores::findFirst ( $id );
			$journalID=$score->journalID;
			if ($score == null) {
				throw new exception ( "数据不存在！" );
			}
			if (strtolower($QC) != strtolower($score->QC)) {
				throw new Exception ( "你只能修改自己的数据。" );
			}
			if ($score->delete () === true) {
				echo '{"result":"success","msg":"' . $id . '"}';
				/*
				 * update count of vrdChecked in journals
				 */
				$scores=NewVideoScores::findByJournalID($journalID);
				$journal=Journals::findFirst($journalID);
				$journal->vrdChecked=$scores->count();
				$journal->save();
			} else {
				throw new exception ( "删除失败！请重试！" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function vrdScoresOldAction() {
		$this->tag->appendTitle ( '|Scores' );
		$this->view->setTemplateBefore ( "vrd" );
		$numberPage = 1;
		if ($this->request->isPost ()) {
			$visit_date = $this->request->getPost ( 'visit_date', 'string' );
			$journal_creator = $this->request->getPost ( 'journal_creator', 'string' );
			$contract_no = $this->request->getPost ( 'contract_no', 'string' );
			$QC = $this->request->getPost ( 'QC', 'string' );
			$auditResult = $this->request->getPost ( 'auditResult', 'string' );
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
			if ($auditResult) {
				$query->andWhere ( "auditResult=:auditResult: ", [ 
						"auditResult" => "$auditResult" 
				] );
				$hasRequest = true;
			}
			if ($journal_creator) {
				$query->andWhere ( "LLI like :journal_creator:", [ 
						"journal_creator" => "$journal_creator%" 
				] );
				$hasRequest = true;
			}
			if ($this->session->get ( 'auth' ) ['level'] > 9) {
				if ($QC) {
					$query->andWhere ( "QC like :QC:", [ 
							"QC" => "$QC%" 
					] );
					$hasRequest = true;
				}
			} else {
				$query->andWhere ( "QC = :QC:", [ 
						"QC" => $this->session->get ( 'auth' ) ['name'] 
				] );
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
				"limit" => 20,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
	public function vrdScoresAction(){
		$this->tag->appendTitle ( '|Scores' );
		$this->view->setTemplateBefore ( "vrd" );
		$numberPage = 1;
		if ($this->request->isPost ()) {
			$visit_date = $this->request->getPost ( 'visit_date', 'string' );
			$journal_creator = $this->request->getPost ( 'journal_creator', 'string' );
			$contract_no = $this->request->getPost ( 'contract_no', 'string' );
			$QC = $this->request->getPost ( 'QC', 'string' );
			$auditResult = $this->request->getPost ( 'auditResult', 'string' );
			$obj = $this->request->getPost ( 'object', 'string' );
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
			if ($auditResult) {
				$query->andWhere ( "auditResult=:auditResult: ", [
						"auditResult" => "$auditResult"
				] );
				$hasRequest = true;
			}
			if ($journal_creator) {
				$query->andWhere ( "LLI like :journal_creator:", [
						"journal_creator" => "$journal_creator%"
				] );
				$hasRequest = true;
			}
			if ($this->session->get ( 'auth' ) ['level'] > 9) {
				if ($QC) {
					$query->andWhere ( "QC like :QC:", [
							"QC" => "$QC%"
					] );
					$hasRequest = true;
				}
			} else {
				$query->andWhere ( "QC = :QC:", [
						"QC" => $this->session->get ( 'auth' ) ['name']
				] );
			}
			if ($contract_no) {
				$query->andWhere ( "contractNo = :contract_no:", [
						"contract_no" => "$contract_no"
				] );
				$hasRequest = true;
			}
			if($hasRequest && $obj){
				$query->andWhere ( "object = :obj:", [
						"obj" => "$obj"
				] );
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
		$journals = NewVideoScores::find ( $parameters );
		if (count ( $journals ) == 0) {
			$this->flash->notice ( "The search did not find any scores" );
		}
		$paginator = new Paginator ( array (
				"data" => $journals,
				"limit" => 20,
				"page" => $numberPage
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
	public function fetchStartPointsAction($visitDate) {
		ini_set ( "max_execution_time", 600 );
		$this->view->disable ();
		try {
			// $visitDate = '2018-09-19';
			if ($visitDate == "") {
				throw new exception ( 'visitDate not available' );
			}
			$llis = Journals::find ( [ 
					"columns" => "distinct journal_creator",
					"conditions" => "visit_date = :visitDate: and lon_from is null and lon is not null and visit_time != ''",
					"order" => "journal_creator",
					"limit" => "10",
					"bind" => [ 
							"visitDate" => "$visitDate" 
					] 
			] );
			$lliArray = Array ();
			$lliCount = $llis->count ();
			if ($lliCount == 0) {
				throw new exception ( 'allDone' );
			}
			for($k = 0; $k < $lliCount; $k ++) {
				$lliArray [$k] = $llis [$k]->journal_creator;
			}
			$journals = Journals::find ( [ 
					"conditions" => "visit_date = :visitDate: and lon_from is null and lon is not null and visit_time != '' and journal_creator in ({llis:array}) ",
					"order" => "journal_creator,visit_time",
					"bind" => [ 
							"visitDate" => "$visitDate",
							"llis" => $lliArray 
					] 
			] );
			$count = $journals->count ();
			if ($count < 1) {
				throw new exception ( 'allDone' );
			}
			
			$journals [0]->lon_from = $journals [0]->lon;
			$journals [0]->lat_from = $journals [0]->lat;
			$journals [0]->time_from = $journals [0]->visit_time;
			
			$journals [0]->update ();
			for($i = 0; $i < $count - 1; $i ++) {
				$j = $i + 1;
				$lonf = $journals [$i]->lon;
				$latf = $journals [$i]->lat;
				$timeFrom = $journals [$i]->visit_time;
				$creator = $journals [$i]->journal_creator;
				if ($journals [$j]->journal_creator == $creator) {
					$journals [$j]->lon_from = $lonf;
					$journals [$j]->lat_from = $latf;
					$journals [$j]->time_from = $timeFrom;
					$journals [$j]->update ();
				} else {
					$journals [$j]->lon_from = $journals [$j]->lon;
					$journals [$j]->lat_from = $journals [$j]->lat;
					$journals [$j]->time_from = $journals [$j]->visit_time;
					$journals [$j]->update ();
				}
			}
			echo '{"result":"unDone","visitDate":"' . $visitDate . '"}';
		} catch ( Exception $e ) {
			echo '{"result":"' . $e->getMessage () . '","visitDate":"' . $visitDate . '"}';
		}
	}
	public function testAction() {
		$journal = Journals::findFirst ( 4559082 );
		$journal->lon_from = $journal->lon;
		$journal->lat_from = $journal->lat;
		if ($journal->update () === false) {
			foreach ( $journal->getMessages () as $msg ) {
				echo $msg;
			}
		}
	}
	public function clearStartPointsAction($visitDate) {
		// $visitDate = '2018-09-19';
		$this->view->disable ();
		try {
			if ($visitDate == "") {
				throw new exception ( 'visitDate not available' );
			}
			$query = $this->modelsManager->createQuery ( 'update Journals set lon_from=null, lat_from=null,time_from=null WHERE visit_date = :visitDate:' );
			$query->execute ( [ 
					'visitDate' => "$visitDate" 
			] );
			echo '{"result":"success","visitDate":"' . $visitDate . '"}';
		} catch ( exception $e ) {
			echo '{"result":"' . $e->getMessage () . '","visitDate":"' . $visitDate . '"}';
		}
	}
	public function distanceAction() {
		$this->tag->setTitle ( 'Mileage' );
	}
	public function fetchLocationsAction($visitDate) {
		$this->view->disable ();
		// $visitDate = '2018-09-22';
		$journals = Journals::find ( [ 
				"columns" => "j_id,lon,lat,lon_from,lat_from",
				"conditions" => "visit_date = :visitDate: and lat is not null and lat_from is not null and distance is null",
				"limit" => "100",
				"bind" => [ 
						"visitDate" => "$visitDate" 
				] 
		] );
		echo json_encode ( $journals );
	}
	public function uploadDistanceAction() {
		$this->view->disable ();
		$j_id = $this->request->getPost ( 'j_id' );
		$distance = $this->request->getPost ( 'distance' );
		$duration = $this->request->getPost ( 'duration' );
		
		/*
		 * $j_id = '95230';
		 * $distance='15645';
		 * $duration='158';
		 */
		try {
			if ($j_id == '') {
				throw new exception ( 'j_id not exist' );
			}
			$journal = Journals::findFirstByJId ( $j_id );
			$journal->distance = $distance;
			$journal->duration = $duration;
			if ($journal->update () === false) {
				throw new exception ( 'Failed updating' );
			}
			echo '{"result":"success","id":"' . $j_id . '"}';
		} catch ( Exception $e ) {
			echo '{"result":"failed","errMsg":"' . $e->getMessage () . '","id":"' . $j_id . '"}';
		}
	}
	public function clearDistanceAction() {
		$visitDate = $this->request->getPost ( 'visitDate' );
		// $visitDate = '2018-09-19';
		$this->view->disable ();
		try {
			if ($visitDate == "") {
				throw new exception ( 'visitDate not available' );
			}
			$query = $this->modelsManager->createQuery ( 'update Journals set distance=null, duration=null WHERE visit_date = :visitDate:' );
			$query->execute ( [ 
					'visitDate' => "$visitDate" 
			] );
			echo '{"result":"success","visitDate":"' . $visitDate . '"}';
		} catch ( exception $e ) {
			echo '{"result":"' . $e->getMessage () . '","visitDate":"' . $visitDate . '"}';
		}
	}
	public function createHomeLogAction($visitDate) {
		ini_set ( "max_execution_time", 600 );
		$this->view->disable ();
		// $visitDate = '2018-10-01';
		try {
			if ($visitDate == "") {
				throw new exception ( 'visitDate not available' );
			}
			$collectorsHasHomeLog = Journals::find ( [ 
					"columns" => "distinct journal_creator",
					"conditions" => "visit_date=:visitDate: and detail='通勤专用日志'",
					"bind" => [ 
							"visitDate" => "$visitDate" 
					] 
			] );
			$lliCount = $collectorsHasHomeLog->count ();
			$llis = Array ();
			if ($lliCount != 0) {
				for($i = 0; $i < $lliCount; $i ++) {
					$llis [$i] = $collectorsHasHomeLog [$i]->journal_creator;
				}
			} else {
				$llis = [ 
						'978' 
				];
			}
			$collectors = Journals::find ( [ 
					"columns" => "distinct journal_creator",
					"conditions" => "visit_date=:visitDate: and visit_time !='' and journal_creator not in ({llis:array})",
					"limit" => "100",
					"bind" => [ 
							"visitDate" => "$visitDate",
							"llis" => $llis 
					] 
			] );
			if ($collectors->count () == "0") {
				echo '{"result":"allDone","msg":"ok","visitDate":"' . $visitDate . '"}';
				return;
			}
			foreach ( $collectors as $collector ) {
				$checkIn = CheckIns::find ( [ 
						"columns" => "sign_in_time,lon,lat",
						"conditions" => "sign_in_date=:visitDate: and llc = :llc:",
						"order" => "llc,sign_in_time",
						"bind" => [ 
								"visitDate" => "$visitDate",
								"llc" => "$collector->journal_creator" 
						] 
				] );
				
				if ($checkIn->count () > 0) {
					/*
					 * home -> first visit
					 */
					$log = new Journals ();
					$log->visit_date = $visitDate;
					$log->journal_creator = $collector->journal_creator;
					$log->visit_time = $checkIn [0]->sign_in_time;
					$log->lon = $checkIn [0]->lon;
					$log->lat = $checkIn [0]->lat;
					$log->detail = '通勤专用日志';
					$log->remark = '从家出发';
					if ($log->save () === false) {
						foreach ( $log->getMessages () as $msg ) {
							throw new Exception ( $msg->getMessage () );
						}
					}
					
					/*
					 * last visit->home log
					 */
					$cnt = $checkIn->count () - 1;
					$logEnd = new Journals ();
					$logEnd->visit_date = $visitDate;
					$logEnd->journal_creator = $collector->journal_creator;
					$logEnd->visit_time = $checkIn [$cnt]->sign_in_time;
					$logEnd->lon = $checkIn [$cnt]->lon;
					$logEnd->lat = $checkIn [$cnt]->lat;
					$logEnd->detail = '通勤专用日志';
					$logEnd->remark = '下班回家';
					if ($logEnd->save () === false) {
						foreach ( $logEnd->getMessages () as $msg ) {
							throw new Exception ( $msg->getMessage () );
						}
					}
				}
			}
			echo '{"result":"unDone","msg":"ok","visitDate":"' . $visitDate . '"}';
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '","visitDate":"' . $visitDate . '"}';
		}
	}
	public function delHomeLogAction($visitDate) {
		$this->view->disable ();
		// $visitDate='2018-10-01';
		try {
			if ($visitDate == "") {
				throw new exception ( 'visitDate not available' );
			}
			$query = $this->modelsManager->createQuery ( 'delete from Journals WHERE visit_date = :visitDate: and detail="通勤专用日志"' );
			$query->execute ( [ 
					'visitDate' => "$visitDate" 
			] );
			echo '{"result":"success","visitDate":"' . $visitDate . '"}';
		} catch ( exception $e ) {
			echo '{"result":"' . $e->getMessage () . '","visitDate":"' . $visitDate . '"}';
		}
	}
}