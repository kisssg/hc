<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Model\Manager;
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
			$QC = $this->request->getPost ( 'QC' );
			$ID_employee = $this->request->getPost ( 'ID_employee' );
                        $remark=$this->request->getPost('remark');
			
			$query = new Criteria ();
			$query->setModelName ( "CameraScores" );
			$query->where ( "status='ok'" );
			$query->limit ( "3000" );
			$query->orderBy ( "score ASC,NAME_COLLECTOR,ACTION_DATE,ACTION_TIME,TEXT_CONTRACT_NUMBER" );
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
			if ($ID_employee) {
				$query->andWhere ( "ID_EMPLOYEE = :ID_EMPLOYEE:", [ 
						"ID_EMPLOYEE" => "$ID_employee" 
				] );
				$hasRequest = true;
			}
                        if($remark){
                            $query->andWhere("remark like :remark:",[
                               "remark"=>"%$remark%" 
                            ]);                            
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
		if ($this->request->isPost ()) {
			$dateIn = $this->request->getPost ( 'visit_date', 'string' );
			$this->persistent->dateIn = $dateIn;
		} else {
			$dateIn = $this->persistent->dateIn;
		}
		if ($dateIn == "") {
			$dateIn = date ( "Y-m-d" );
		}
		$weekday = date ( 'w', strtotime ( $dateIn ) );
		$startDayOffset = 2;
		$startWeekDay = $weekday - $startDayOffset;
		if ($startWeekDay < 0) {
			$startWeekDay = $startWeekDay + 7;
		}
		$actualDate = date_create ( $dateIn );
		$startDate = date_sub ( $actualDate, date_interval_create_from_date_string ( $startWeekDay . ' days' ) );
		$this->view->startDate = $startDate->format("Y-m-d");
		$this->view->endDate=$startDate->add(date_interval_create_from_date_string ( '6 days' ))
									   ->format("Y-m-d");
		
		$loginQC=trim ( $this->session->get ( 'auth' ) ['name'] );
		$sumQC=CameraScores::sum([
				"column"=>"SUM_VIDIO_TIME_DURATION",
				"conditions"=>"ACTION_DATE between :startDate: and :endDate: and QC=:qc: and status='ok'",
				"bind"=>[
						"startDate"=>$this->view->startDate,
						"endDate"=>$this->view->endDate,
						"qc"=>$loginQC
				]
		]);
		$sumAll=CameraScores::sum([
				"column"=>"SUM_VIDIO_TIME_DURATION",
				"conditions"=>"ACTION_DATE between :startDate: and :endDate: and QC !='system' and QC !='' and status='ok'",
				"bind"=>[
						"startDate"=>$this->view->startDate,
						"endDate"=>$this->view->endDate,
				]
		]);
		$countQC=CameraScores::count([
				"distinct"=>"QC",
				"conditions"=>"ACTION_DATE between :startDate: and :endDate: and QC !='system' and status='ok'",
				"bind"=>[
						"startDate"=>$this->view->startDate,
						"endDate"=>$this->view->endDate,
				]
		]);
		if($countQC==0){
			return;
		}
		$sumAverage=$sumAll/$countQC;
									   
		$this->view->sumQC=$sumQC;
		$this->view->sumAverage=$sumAverage;
		$this->view->checked = 100 * $sumQC/($sumAverage+$sumQC);
		$this->view->averageChecked =100 * $sumAverage/($sumAverage+$sumQC);
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
			
			// remarks
			$cheatType = $this->request->getPost ( 'cheatType' );
			$noIntroAnno = $this->request->getPost ( 'noIntroAnno' );
			// $week=$this->request->getPost('week');
			$camera = CameraScores::findFirst ( $id );
			$camera->object = $object;
			$camera->score = $score;
			$camera->remark = str_replace(PHP_EOL, '', $remark);
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
			$camera->cheatType = $cheatType;
			$camera->noIntroAnno = $noIntroAnno;
			if (date ( "w", strtotime ( $camera->ACTION_DATE ) ) == 0) {
				$date = date_create ( $camera->ACTION_DATE );
				$difday = - 6;
				date_add ( $date, date_interval_create_from_date_string ( $difday . ' days' ) );
				$week = date_format ( $date, 'Y-m-d' );
			} else {
				$date = date_create ( $camera->ACTION_DATE );
				$difday = 1 - date ( "w", strtotime ( $camera->ACTION_DATE ) );
				date_add ( $date, date_interval_create_from_date_string ( $difday . ' days' ) );
				$week = date_format ( $date, 'Y-m-d' );
			}
			$camera->week = $week;
			if ($camera->QSCcreateDate == null) {
				$camera->QSCcreateDate = date ( "Y-m-d" );
				$camera->QSCcreateTime = date ( "H:i:s" );
			} else {
				$camera->QSCeditDate = date ( "Y-m-d" );
				$camera->QSCeditTime = date ( "H:i:s" );
			}
			
			if (strtolower ( $camera->QC ) != strtolower ( $submitQC ) && $camera->QC != "") {
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
	public function pickAction() {
		$this->view->disable ();
		try {
			$id = $this->request->getPost ( 'id' );
			$QC = trim ( $this->session->get ( 'auth' ) ['name'] );
			$unCheck=CameraScores::count([
					"nullif(object,'') is null and QC=:qc: and status='ok'",
					"bind"=>[
							"qc"=>$QC
					]
			]);
			if($unCheck>2){
				throw new exception("请先核查完已领数据。");
			}
			$toPick = CameraScores::findFirst ( $id );
			if ($toPick->QC == '') {
				$toPick->QC = $QC;
				$toPick->editLog = $toPick->editLog . "|" . $QC . "pick" . date ( 'ymdHis' );
				if ($toPick->save ()) {
					echo '{"result":"success","msg":""}';
				} else {
					throw new exception ( 'Failed Picking' );
				}
			} else {
				throw new exception ( $toPick->QC . " 快人一步。" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function pickLLIAction() {
		$this->view->disable ();
		try {
			$QC = trim ( $this->session->get ( 'auth' ) ['name'] );
			
			$unCheck=CameraScores::count([
					"nullif(object,'') is null and QC=:qc: and status='ok'",
					"bind"=>[
							"qc"=>$QC
					]
			]);
			if($unCheck>2){
				throw new exception("请先核查完已领数据。");
			}
			
			$date = $this->request->getPost ( 'date' );
			$lli = $this->request->getPost ( 'lli' );
			$connection = $this->db;
			$sql = "update fc_camera_scores set QC='$QC' where ACTION_DATE='$date' AND NAME_COLLECTOR='$lli' and score is null and QC='' and SUM_VIDIO_TIME_DURATION <120 and ignoreReason=''";
			$result = $connection->query ( $sql );
			if ($result === false) {
				throw new exception ( 'Failed' );
			} else {
				echo '{"result":"success","msg":""}';
			}
		} catch ( exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function batchDeleteAction() {
		$this->view->disable ();
		try {
			$user = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='batchDelete'",
					"bind" => [ 
							"user" => $user 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "你没有该权限。请找管理员申请。" );
			}
			$date = $this->request->getPost ( "date" );
			$connection = $this->db;
			$sql = "update `fc_camera_scores` set status='obsoleted' where action_date='$date' #and status=''";
			$result = $connection->query ( $sql );
			if ($result === false) {
				throw new Exception ( "Failed updating data in base" );
			} else {
				echo '{"result":"success","msg":"成功删除批次：' . $date . '"}';
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function delUnenableAction() {
		$this->view->disable ();
		try {
			$user = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='batchDelete'",
					"bind" => [ 
							"user" => $user 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "你没有该权限。请找管理员申请。" );
			}
			$connection = $this->db;
			$sql = "update `fc_camera_scores` set status='obsoleted' where status=''";
			$result = $connection->query ( $sql );
			if ($result === false) {
				throw new Exception ( "Failed updating data in base" );
			} else {
				echo '{"result":"success","msg":"成功删除所有未启用的数据。"}';
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function batchEnableAction() {
		$this->view->disable ();
		try {
			$user = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='batchEnable'",
					"bind" => [ 
							"user" => $user 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "您没有这个权限！请找管理员获取权限。" );
			}
			$date = $this->request->getPost ( "date" );
			$connection = $this->db;
			$sql = "update `fc_camera_scores` set status='ok' where action_date='$date' and status=''";
			$result = $connection->query ( $sql );
			if ($result === false) {
				throw new Exception ( "Failed updating data in base" );
			} else {
				echo '{"result":"success","msg":"成功启用' . $date . '"}';
			}
		} catch ( exeption $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function checkCheatingAction() {
		$this->view->disable ();
		try {
			$user = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='checkCheating'",
					"bind" => [ 
							"user" => $user 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "您没有这个权限！请找管理员获取权限。" );
			}
			$date = $this->request->getPost ( 'date' );
			if($this->checkDuration($date)==false){
				throw new exception("核查时长少于6秒的视频失败了。重新试试？");
			}
			$manager = $this->db;
			$sql = "update
					`fc_camera_scores`
				set cheating='0',object='-',score=0,qc='system',cheatType='No video but audio',remark='有录音无录像',
				QSCCREATEDATE=CURDATE(),QSCCREATETIME=CURTIME()
				WHERE
					flag_with_audio = '1'
				AND flag_with_vidio = '0'
				and action_date='$date';";
			$result = $manager->query ( $sql );
			if ($result === false) {
				throw new exception ( 'Failed updating data in base' );
			} else {
				echo '{"result":"success","msg":"' . $date . '数据已核查完有录音无视频数据。"}';
			}
		} catch ( exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function checkDuration($date) {
		try {			
			$manager = $this->db;
			$sql = "update
			`fc_camera_scores`
			set cheating='0',object='-',score=0,qc='system',cheatType='No collection action',remark='录像时长少于6秒',
			QSCCREATEDATE=CURDATE(),QSCCREATETIME=CURTIME()
			WHERE
			SUM_VIDIO_TIME_DURATION <= 0.1
			AND flag_with_vidio = '1'
			and action_date='$date';";
			$result = $manager->query ( $sql );
			if ($result === false) {
				throw new exception ( 'Failed updating data in base' );
			} else {
				return true;
			}
		} catch ( exception $e ) {
			return false;
		}
	}
	public function batchManageAction() {
		$batchList = CameraScores::find ( [ 
				"columns" => "distinct (ACTION_DATE) AS date,count(ACTION_DATE) AS count,count(nullif(status,'')) as countOk,(count(QC)-count(nullif(QC,'system'))) autoCheck,uploadTime",
				"conditions" => "status != 'obsoleted'",
				"order" => "ACTION_DATE DESC",
				"limit" => "50",
				"group" => "ACTION_DATE" 
		] );
		$currentPage = $this->request->getQuery ( "page", "int" );
		$paginator = new Paginator ( [ 
				"data" => $batchList,
				"limit" => "50",
				"page" => $currentPage 
		] );
		
		$page = $paginator->getPaginate ();
		echo "<table class='contracts' style='width:auto;'>
		<tr>
		<td>Action Date</td>
		<td>Count</td>
		<td>Count OK</td>
		<td>Auto checked</td>
		<td>Upload Time</td>
		<td>Action </td>
		</tr>";
		foreach ( $page->items as $item ) {
			if ($item->count == $item->countOk) {
				$enableBtn = "";
			} else {
				$enableBtn = "<button onclick='return CameraScore.batchEnable(\"" . $item->date . "\")'>启用</button>";
			}
			echo "<tr><td>" . $item->date . "</td><td>" . $item->count . "</td><td>" . $item->countOk . "</td><td>" . $item->autoCheck . "</td><td>" . $item->uploadTime . "</td><td>" . $enableBtn . "<button onclick='return CameraScore.checkCheating(\"" . $item->date . "\")'>录音作假核查</button>" . "<button onclick='return CameraScore.addIssue(\"" . $item->date . "\")'>批量添加异常</button>" . "<button onclick='return CameraScore.batchDelete(\"" . $item->date . "\")'>删除</button>" . "</td></tr>";
		}
		echo "</table>";
		echo '<div class="clearfix pagination">
	<a class="number" href="?page=1">&laquo;</a>' . '
	<a class="number" href="?page=' . $page->before . '">&lsaquo;</a>
	<a class="number" href="?page=' . $page->next . '">&rsaquo;</a>
	<a class="number" href="?page=' . $page->last . '">&raquo;</a>
	</div>
	' . $page->current, "/", $page->total_pages;
		echo "<button class='btn btn-primary' onclick='return CameraScore.delUnenable();'>删除全部未启用的数据</button>";
	}
	public function scoreDelAction() {
		$this->view->disable ();
		try {
			$id = $this->request->getPost ( "id" );
			$camera = CameraScores::findFirst ( $id );
			$submitQC = trim ( $this->session->get ( 'auth' ) ['name'] );
			
			if ($camera->QC != $submitQC) {
				throw new exception ( "你只能修改自己的数据，这条数据属于" . $camera->QC );
			}
			
			if ($camera->authority != 'delete') {
				// throw new exception ( "请申请删除权限先！" );
			}
			
			$camera->object = "";
			$camera->score = "";
			$camera->remark = "";
			$camera->cheating = "";
			$camera->recSurrounding = "";
			$camera->announceContract = "";
			$camera->selfIntro = "";
			$camera->RPCEndRec = "";
			$camera->askOthers = "";
			$camera->leaveMsg = "";
			$camera->askForDebt = "";
			$camera->tellConsequence = "";
			$camera->negotiatePay = "";
			$camera->provideSolution = "";
			$camera->specificCollect = "";
			$camera->payHierarchy = "";
			$camera->updateDT = "";
			$camera->cashCollect = "";
			
			$camera->cheatType = "";
			$camera->noIntroAnno = "";
			
			$camera->QSCeditDate = date ( "Y-m-d" );
			$camera->QSCeditTime = date ( "H:i:s" );
			$camera->authority = "-";
			$camera->editLog = $camera->editLog . "del-" . $camera->QC . date ( "Ymd" );
			$camera->QC = "";
			if ($camera->save () == false) {
				throw new exception ( "删除失败！请重试。" );
			} else {
				echo '{"result":"success","msg":""}';
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function addIssueAction($date) {
		$this->view->disable ();
		try {
			// $date = '2019-02-15';
			$submitQC = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='addIssue'",
					"bind" => [ 
							"user" => $submitQC 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "您没有这个权限！请找管理员获取权限。" );
			}
			$query = new Criteria ();
			$query->setModelName ( "CameraScores" );
			$query->where ( "(updateDT = '0' OR cheating = '0')" );
			$query->inWhere ( "VISIT_RESULT", [ 
					'Pay later',
					'Promise to pay',
					'PTP DD',
					'Settlement',
					'Payment with collector',
					'Already Paid',
					'LFC - Pay later',
					'LFC - Promise to pay - Non DD',
					'LFC - Settlement',
					'LFC - Promise to pay',
					'LFC - Payment with collector',
					'LFC - Already Paid',
					'EFC - Pay later',
					'EFC - Promise to pay',
					'EFC - Promise to pay - Non DD',
					'EFC - Payment with collector',
					'EFC - Already Paid' 
			] );
			$query->andWhere ( "ACTION_DATE=:date:", [ 
					"date" => "$date" 
			] );
			$toAdd = CameraScores::find ( $query->getParams () );
			foreach ( $toAdd as $item ) {
				$issueAdded = json_decode ( $item->issueAdded );
				if (is_object ( $issueAdded ) && $issueAdded->payRelated == 1) {
					echo $item->TEXT_CONTRACT_NUMBER . "之前已添加同类异常，不再添加。" . "<br/>";
				} else {
					echo $item->id . $item->VISIT_RESULT . $item->ACTION_DATE . $item->updateDT . "-" . $item->cheating . '<br/>';
					// TODO: add issue here;
					$issue = new Issues ();
					$issue->date = $date;
					$issue->contract_no = $item->TEXT_CONTRACT_NUMBER;
					$issue->client_name = '';
					$issue->phone = '';
					$issue->object = '外催员/法律调查员';
					$issue->city = $item->SH_CITY;
					$issue->region = '';
					$issue->collector = $item->NAME_COLLECTOR;
					$issue->employeeID = $item->ID_EMPLOYEE;
					$issue->issue_type = "Collector's mistake 催收员过错";
					$issue->issue = 'Invalid video recording 无效录像';
					$issue->remark = $item->id . $item->remark . ', 外访结果：' . $item->VISIT_RESULT . ',如实登记外访结果得分：' . $item->updateDT . "，Did LLI record fake collection video？" . $item->cheating . "," . $item->cheatType;
					$issue->responsible_person = $item->TL_NAME;
					$issue->feedback = '';
					$issue->qc_name = $item->QC;
					$issue->result = '有效';
					$issue->close_reason = '';
					$issue->callback_id = '';
					$issue->add_time = date ( "Y-m-d H:i:s" );
					$issue->close_person = 'system';
					$issue->close_time = date ( "Y-m-d H:i:s" );
					$issue->edit_log = 'auto created by' . $submitQC;
					$issue->source = 'camera checking';
					$issue->harassment_type = 'Other cheating behavior';
					$issue->uploader = 'system';
					
					if ($issue->save () === false) {
						throw new exception ( "添加失败！" );
					}
					
					if (is_object ( $issueAdded )) {
						$issueAdded->payRelated = 1;
						$item->issueAdded = json_encode ( $issueAdded );
						$item->save ();
					} else {
						$item->issueAdded = '{"payRelated":1,"cheating":0}';
						$item->save ();
					}
				}
			}
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function addCheatIssueAction($date) {
		$this->view->disable ();
		try {
			// $date = '2019-02-15';
			$submitQC = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='addIssue'",
					"bind" => [ 
							"user" => $submitQC 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "您没有这个权限！请找管理员获取权限。" );
			}
			$query = new Criteria ();
			$query->setModelName ( "CameraScores" );
			$query->where ( "cheating = '0'" );
			$query->andWhere ( "ACTION_DATE=:date:", [ 
					"date" => "$date" 
			] );
			$toAdd = CameraScores::find ( $query->getParams () );
			foreach ( $toAdd as $item ) {
				$issueAdded = json_decode ( $item->issueAdded );
				if (is_object ( $issueAdded ) && $issueAdded->cheating == 1) {
					echo $item->TEXT_CONTRACT_NUMBER . "之前已添加同类异常，不再添加。" . "<br/>";
				} else {
					echo $item->id . $item->VISIT_RESULT . $item->ACTION_DATE . $item->updateDT . "-" . $item->cheating . '<br/>';
					// TODO: add issue here;
					$issue = new Issues ();
					$issue->date = $date;
					$issue->contract_no = $item->TEXT_CONTRACT_NUMBER;
					$issue->client_name = '';
					$issue->phone = '';
					$issue->object = '外催员/法律调查员';
					$issue->city = $item->SH_CITY;
					$issue->region = '';
					$issue->collector = $item->NAME_COLLECTOR;
					$issue->employeeID = $item->ID_EMPLOYEE;
					$issue->issue_type = "Collector's mistake 催收员过错";
					$issue->issue = 'Fake visit/video 虚假外访/视频';
					$issue->remark = $item->id . $item->remark . '，外访结果：' . $item->VISIT_RESULT . "，作假类型：" . $item->cheatType;
					$issue->responsible_person = $item->TL_NAME;
					$issue->feedback = '';
					$issue->qc_name = $item->QC;
					$issue->result = '有效';
					$issue->close_reason = '';
					$issue->callback_id = '';
					$issue->add_time = date ( "Y-m-d H:i:s" );
					$issue->close_person = 'system';
					$issue->close_time = date ( "Y-m-d H:i:s" );
					$issue->edit_log = 'auto created by' . $submitQC;
					$issue->source = 'camera checking';
					$issue->harassment_type = 'Other cheating behavior';
					$issue->uploader = 'system';
					
					if ($issue->save () === false) {
						throw new exception ( "添加失败！" );
					}
					
					if (is_object ( $issueAdded )) {
						$issueAdded->cheating = 1;
						$item->issueAdded = json_encode ( $issueAdded );
						$item->save ();
					} else {
						$item->issueAdded = '{"payRelated":0,"cheating":1}';
						$item->save ();
					}
				}
			}
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function getDateRangeAction(){
		$dateIn="";
		if ($dateIn == "") {
			$dateIn = date ( "Y-m-d" );
		}
		$weekday = date ( 'w', strtotime ( $dateIn ) );
		$startDayOffset = 2;
		$startWeekDay = $weekday - $startDayOffset;
		if ($startWeekDay < 0) {
			$startWeekDay = $startWeekDay + 7;
		}
		$actualDate = date_create ( $dateIn );
		$startDate = date_add ( $actualDate, date_interval_create_from_date_string ( $startWeekDay . ' days' ) );
		$this->view->startDate = $startWeekDay;
		echo $startDate->format("Y-m-d");
	}
	public function addVisitResultIndexAction($date) {
		$this->view->disable ();
		try {
			$user = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='addVisitResultIndex'",
					"bind" => [ 
							"user" => $user 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "你没有该权限。请找管理员申请。" );
			}
			// $date = $this->request->getPost ( "date" );
			$connection = $this->db;
			$sql = "update `fc_camera_scores` set visitResultIndex=1 where ACTION_DATE='$date' and VISIT_RESULT in ('Pay later',
				'Promise to pay',
				'PTP DD',
				'Settlement',
				'Payment with collector',
				'Already Paid',
				'LFC - Pay later',
				'LFC - Promise to pay - Non DD',
				'LFC - Settlement',
				'LFC - Promise to pay',
				'LFC - Payment with collector',
				'LFC - Already Paid',
				'EFC - Pay later',
				'EFC - Promise to pay',
				'EFC - Promise to pay - Non DD',
				'EFC - Payment with collector',
				'EFC - Already Paid'
				);";
			$result = $connection->query ( $sql );
			if ($result === false) {
				throw new Exception ( "Failed updating data in base" );
			} else {
				echo '{"result":"success","msg":"外访结果序列号添加成功：' . $date . '"}';
			}
		} catch ( Exception $e ) {
			echo '{"result":"FAILED","msg":"' . $e->getMessage () . '"}';
		}
	}
	function transferAction() {
		try {
			$this->view->disable ();
			$user = trim ( $this->session->get ( 'auth' ) ['name'] );
			$authority = Authorities::findFirst ( [ 
					"user=:user: and module='cameraScores' and authority='transfer'",
					"bind" => [ 
							"user" => $user 
					] 
			] );
			if ($authority == null) {
				throw new exception ( "你没有该权限。请找管理员申请。" );
			}
			$to = $this->request->getPost ( "to" );
			$to = str_replace ( " ", ".", $to );
			$exist_user = Users::count ( [ 
					"username = :username:",
					"bind" => [ 
							"username" => "$to" 
					] 
			] );
			if ($exist_user == 0) {
				throw new exception ( "User not exist" );
			}
			$ids = $this->request->getPost ( "ids" );
			$toTrans = CameraScores::find ( [ 
					"conditions" => "id in ({ids:array}) and nullif(score,'') is null",
					"bind" => [ 
							"ids" => $ids 
					] 
			] );
			$count = 0;
			foreach ( $toTrans as $item ) {
				$item->editLog = $item->editLog . "|from " . $item->QC . " by " . $user . " on " . date ( "YmdHis" );
				$item->QC = $to;
				if ($item->save () === true) {
					$count ++;
				}
			}
			echo '{"result":"success","msg":"' . $count . '"}';
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
}