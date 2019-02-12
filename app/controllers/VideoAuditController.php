<?php
class VideoAuditController extends ControllerBase {
	public function initialize() {
	}
	public function getAction() {
		$this->view->disable ();
		try {
			$auditor = $this->session->get ( 'auth' ) ['name'];
			if ($auditor == "") {
				throw new Exception ( "Login session expired!" );
			}
			$vsID = $this->request->getPost ( "vsID" );
			$audit = VideoAudits::findFirst ( [ 
					"vsID=:vsID:",
					"bind" => [ 
							"vsID" => "$vsID" 
					] 
			] );
			if ($vsID == "" || $audit == null) {
				throw new exception ( "不存在相关内审数据。" );
			}
			echo json_encode ( $audit );
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function addAction() {
		$this->view->disable ();
		try {
			$auditor = $this->session->get ( 'auth' ) ['name'];
			if ($auditor == "") {
				throw new exception ( "Login session expired!" );
			}
			$result = $this->request->getPost ( "result" );
			$remark = $this->request->getPost ( "remark" );
			$visitDate = $this->request->getPost ( "visitDate" );
			$visitTime = $this->request->getPost ( "visitTime" );
			$contractNo = $this->request->getPost ( "contractNo" );
			$vsID = $this->request->getPost ( "vsID" );
			
			// find exists
			$audit = VideoAudits::findFirstByvsID ( $vsID );
			if ($audit == null) {
				// add new
				$audit = new VideoAudits ();
				$audit->createDate = date ( "Y-m-d" );
				$audit->createTime = date ( "H:i:s" );
			} else {
				if ($audit->auditor != $auditor) {
					throw new Exception ( "你只能修改自己的数据" );
				}				
				$audit->editDate = date ( "Y-m-d" );
				$audit->editTime = date ( "H:i:s" );
			}
			
			// update score's auditResult
			$score = CameraScores::findFirst ( $vsID );
			if ($score == null) {
				throw new Exception ( "不存在对应的评分数据。" );
			} else {
				$score->auditResult = $result;
				if ($score->save () == false) {
					throw new Exception ( "评分的内审状态更新失败！" );
				}
			}
			
			$audit->auditor = $auditor;
			$audit->result = $result;
			$audit->remark = $remark;
			$audit->visitDate = $visitDate;
			$audit->visitTime = $visitTime;
			$audit->contractNo = $contractNo;
			$audit->vsID = $vsID;
			if ($audit->save () == true) {
				echo '{"result":"success","msg":"' . $audit->id . '"}';
			} else {
				throw new Exception ( "Failed updating in database" );
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function deleteAction() {
		$this->view->disable ();
		try {
			$auditor = $this->session->get ( "auth" ) ["name"];
			if ($auditor == "") {
				throw new exception ( "Login session expired!" );
			}
			$vsID = $this->request->getPost ( "vsID" );
			$audit = VideoAudits::findFirstByvsID ( $vsID );
			if ($audit == null) {
				throw new exception ( "数据不存在！" );
			}
			if ($audit->auditor != $auditor) {
				throw new Exception ( "你只能修改自己的数据" );
			}	
			// update score's auditResult
			$score = CameraScores::findFirst ( $vsID );
			if (null === $score) {
				throw new Exception ( "不存在对应的评分数据。" );
			} else {
				$score->auditResult = "blank";
				if ($score->save () === false) {
					throw new Exception ( "评分的内审状态更新失败！" );
				}
			}
			
			if ($audit->delete () === true) {
				echo '{"result":"success","msg":""}';
			}else{
				throw new Exception("从数据库删除数据失败。");
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"' . $e->getMessage () . '"}';
		}
	}
	public function updateAction() {
	}
	public function searchAction() {
	}
}