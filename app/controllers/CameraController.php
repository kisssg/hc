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
			$ID_employee=$this->request->getPost('ID_employee');
			
			$query = new Criteria ();
			$query->setModelName ( "CameraScores" );
			$query->where ( "status='ok'" );
			$query->limit("3000");
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
			
			//remarks
			$cheatType=$this->request->getPost('cheatType');
			$noIntroAnno=$this->request->getPost('noIntroAnno');
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
			$camera->cheatType=$cheatType;
			$camera->noIntroAnno=$noIntroAnno;
			if (date ( "W", strtotime ( $camera->ACTION_DATE ) ) == 0) {
				$difday = - 6;
			} else {
				$date = date_create ( $camera->ACTION_DATE );
				$difday = 1 - date ( "w", strtotime ( $camera->ACTION_DATE ) );
				date_add ( $date, date_interval_create_from_date_string ( $difday . ' days' ) );
				$week = date_format ( $date, 'Y-m-d' );
			}
			$camera->week = $week;
			if ($camera->QC == "") {
				$camera->QSCcreateDate = date ( "Y-m-d" );
				$camera->QSCcreateTime = date ( "H:i:s" );
			} else {
				$camera->QSCeditDate = date ( "Y-m-d" );
				$camera->QSCeditTime = date ( "H:i:s" );
			}
			
			if (strtolower($camera->QC) != strtolower($submitQC) && $camera->QC != "") {
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
	public function pickAction(){
		$this->view->disable();
		try{
			$id=$this->request->getPost('id');			
			$QC = trim ( $this->session->get ( 'auth' ) ['name'] );
			$toPick=CameraScores::findFirst($id);
			if($toPick->QC==''){
				$toPick->QC=$QC;
				if($toPick->save()){
					echo '{"result":"success","msg":""}';
				}else{
					throw new exception('Failed Picking');
				}
			}else{
				throw new exception($toPick->QC." 快人一步。");
			}
		}catch (Exception $e){
			echo '{"result":"failed","msg":"'.$e->getMessage().'"}';
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
			$manager = $this->db;
			$sql = "update
					`fc_camera_scores`
				set cheating='0',object='-',score=0,qc='system',remark='有录音无录像',
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
	public function batchManageAction() {
		$batchList = CameraScores::find ( [ 
				"columns" => "distinct (ACTION_DATE) AS date,count(ACTION_DATE) AS count,count(nullif(status,'')) as countOk,(count(QC)-count(nullif(QC,'system'))) autoCheck,uploadTime",
				"conditions" => "status != 'obsoleted'",
				"order" => "ACTION_DATE DESC",
				"limit"=>"50",
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
		<td>Action</td>
		</tr>";
		foreach ( $page->items as $item ) {
			if ($item->count == $item->countOk) {
				$enableBtn = "";
			} else {
				$enableBtn = "<button onclick='return CameraScore.batchEnable(\"" . $item->date . "\")'>启用</button>";
			}
			echo "<tr><td>" . $item->date . "</td><td>" . $item->count . "</td><td>" . $item->countOk . "</td><td>" . $item->autoCheck . "</td><td>" . $item->uploadTime . "</td><td>" . $enableBtn . "<button onclick='return CameraScore.checkCheating(\"" . $item->date . "\")'>录音作假核查</button>" ."<button onclick='return CameraScore.addIssue(\"" . $item->date . "\")'>批量添加异常</button>" ."<button onclick='return CameraScore.batchDelete(\"" . $item->date . "\")'>删除</button>" . "</td></tr>";
		}
		echo "</table>";
		echo '<div class="clearfix pagination">
	<a class="number" href="?page=1">&laquo;</a>' . '
	<a class="number" href="?page=' . $page->before . '">&lsaquo;</a>
	<a class="number" href="?page=' . $page->next . '">&rsaquo;</a>
	<a class="number" href="?page=' . $page->last . '">&raquo;</a>
	</div>
	' . $page->current, "/", $page->total_pages;
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
			
			$camera->cheatType="";
			$camera->noIntroAnno="";
			
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
			//$date = '2019-02-15';
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
					'Promise to pay',
					'PTP DD',
					'Payment with collector',
					'Already Paid',
					'LFC - Pay later',
					'LFC - Promise to pay - Non DD',
					'LFC - Promise to pay',
					'LFC - Payment with collector',
					'LFC - Already Paid'
			] );
			$query->andWhere ( "ACTION_DATE=:date:", [
					"date" => "$date"
			] );
			$toAdd = CameraScores::find ( $query->getParams () );
			foreach ( $toAdd as $item ) {
				$issueAdded=json_decode($item->issueAdded);
				if(is_object($issueAdded) && $issueAdded->payRelated==1){
					echo $item->TEXT_CONTRACT_NUMBER."之前已添加同类异常，不再添加。"."<br/>";
				}else{
					echo $item->id.$item->VISIT_RESULT . $item->ACTION_DATE . $item->updateDT . "-" . $item->cheating . '<br/>';
					//TODO: add issue here;
					$issue=new Issues();
					$issue->date=$date;
					$issue->contract_no=$item->TEXT_CONTRACT_NUMBER;
					$issue->client_name='';
					$issue->phone='';
					$issue->object='外催员/法律调查员';
					$issue->city=$item->SH_CITY;
					$issue->region='';
					$issue->collector=$item->NAME_COLLECTOR;
					$issue->employeeID=$item->ID_EMPLOYEE;
					$issue->issue_type="Collector's mistake 催收员过错";
					$issue->issue='Invalid video recording';
					$issue->remark=$item->id.$item->remark.'('.$item->VISIT_RESULT.')'. $item->updateDT . "-" . $item->cheating;
					$issue->responsible_person=$item->TL_NAME;
					$issue->feedback='';
					$issue->qc_name=$item->QC;
					$issue->result='有效';
					$issue->close_reason='';
					$issue->callback_id='';
					$issue->add_time=date("Y-m-d H:i:s");
					$issue->close_person='system';
					$issue->close_time=date("Y-m-d H:i:s");
					$issue->edit_log='auto created by'.$submitQC;
					$issue->source='VRD scoring';
					$issue->harassment_type='Other cheating behavior';
					$issue->uploader='system';
					
					if($issue->save()===false){
						throw new exception ("添加失败！");
					}
					
					if(is_object($issueAdded)){
						$issueAdded->payRelated=1;
						$item->issueAdded=json_encode($issueAdded);
						$item->save();
					}else{
						$item->issueAdded='{"payRelated":1,"cheating":0}';
						$item->save();
					}
				}
			}
		} catch ( Exception $e ) {
			echo   $e->getMessage ();
		}
	}
	public function addCheatIssueAction($date) {
		$this->view->disable ();
		try {
			//$date = '2019-02-15';
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
				$issueAdded=json_decode($item->issueAdded);
				if(is_object($issueAdded) && $issueAdded->cheating==1){
					echo $item->TEXT_CONTRACT_NUMBER."之前已添加同类异常，不再添加。"."<br/>";
				}else{
					echo $item->id.$item->VISIT_RESULT . $item->ACTION_DATE . $item->updateDT . "-" . $item->cheating . '<br/>';
					//TODO: add issue here;
					$issue=new Issues();
					$issue->date=$date;
					$issue->contract_no=$item->TEXT_CONTRACT_NUMBER;
					$issue->client_name='';
					$issue->phone='';
					$issue->object='外催员/法律调查员';
					$issue->city=$item->SH_CITY;
					$issue->region='';
					$issue->collector=$item->NAME_COLLECTOR;
					$issue->employeeID=$item->ID_EMPLOYEE;
					$issue->issue_type="Collector's mistake 催收员过错";
					$issue->issue='Fake visit/video';
					$issue->remark=$item->id.$item->remark.'('.$item->VISIT_RESULT.')'. $item->updateDT . "-" . $item->cheating;
					$issue->responsible_person=$item->TL_NAME;
					$issue->feedback='';
					$issue->qc_name=$item->QC;
					$issue->result='有效';
					$issue->close_reason='';
					$issue->callback_id='';
					$issue->add_time=date("Y-m-d H:i:s");
					$issue->close_person='system';
					$issue->close_time=date("Y-m-d H:i:s");
					$issue->edit_log='auto created by'.$submitQC;
					$issue->source='VRD scoring';
					$issue->harassment_type='Other cheating behavior';
					$issue->uploader='system';
					
					if($issue->save()===false){
						throw new exception ("添加失败！");
					}
					
					if(is_object($issueAdded)){
						$issueAdded->cheating=1;
						$item->issueAdded=json_encode($issueAdded);
						$item->save();
					}else{
						$item->issueAdded='{"payRelated":0,"cheating":1}';
						$item->save();
					}
				}
			}
		} catch ( Exception $e ) {
			echo  $e->getMessage ();
		}
	}
}