<?php
class WorkStatusController extends ControllerBase {
	protected function initialize() {
		$this->tag->setTitle ( "WorkStatus" );
	}
	public function indexAction() {
		// $this->view->disable();
	}
	/*
	 * create a work status
	 */
	public function addAction($qc = null, $work = null, $batch = null) {
		try {
			if ($qc == null || $work == null || $batch == null) {
				throw new exception ( "Parameters not enough." );
			}
			$ew = WorkStatus::findFirst ( [ 
					"qc= :qc: AND work = :work: AND batch = :batch:",
					"bind" => [ 
							"qc" => "$qc",
							"work" => "$work",
							"batch" => "$batch" 
					] 
			] );
			if ($ew !== false) { // check if work status exists already;
				throw new exception ( "This work status already exists" );
			}
			$w = new WorkStatus ();
			$w->qc = $qc;
			$w->work = $work;
			$w->batch = $batch;
			$w->createtime = date ( "Y-m-d H:i:s" );
			$w->status = "doing";
			if ($w->create () === false) {
				throw new exception ( "Failed creating the work status" );
			}
			echo '{"result":"ok","reason":"ok"}';
		} catch ( exception $e ) {
			echo '{"result":"failed","reason":"' . $e->getmessage () . '"}';
		}
		$this->view->disable (); // show json data only, no extra html
	}
	
	/*
	 * set work status to done
	 */
	public function doneAction($qc = null, $work = null, $batch = null) {
		try {
			$w = WorkStatus::findFirst ( [ 
					"qc= :qc: AND work = :work: AND batch = :batch:",
					"bind" => [ 
							"qc" => "$qc",
							"work" => "$work",
							"batch" => "$batch" 
					] 
			] );
			if ($w === false) {
				throw new exception ( "Work status not exists" );
			}
			if ($w->status === "done") {
				throw new exception ( "Already done:)" );
			}
			$w->status = "done";
			$w->donetime = date ( "Y-m-d H:i:s" );
			if ($w->update () === false) {
				throw new exception ( "Failed setting work status to done" );
			}
			echo '{"result":"ok","reason":"ok"}';
		} catch ( exception $e ) {
			echo '{"result":"failed","reason":"' . $e->getmessage () . '"}';
		}
		$this->view->disable ();
	}
	
	/*
	 * delete a work status
	 */
	public function deleteAction($id = null) {
		if ($id == null) {
			echo "Parameters not enough";
			return;
		}
		$w = WorkStatus::findFirst ( $id );
		if ($w == null) {
			echo "Nothing found";
			return;
		}
		$w->delete ();
		echo '{"result":"Status with id ' . $id . ' deleted successfully"}';
		$this->view->disable (); // show json data only, no extra html
	}
	
	/*
	 * delete work status of a very work batch
	 */
	public function deleteByBatchAction($work, $batch) {
		$workbatchs = WorkStatus::find ( [ 
				"work = :work: AND batch = :batch:",
				"bind" => [ 
						"work" => "$work",
						"batch" => "$batch" 
				] 
		] );
		foreach ( $workbatchs as $batch ) {
			if ($batch->delete () === false) {
				echo "Sorry, we can't delete the WorkStatus right now: \n";
				$messages = $batch->getMessages ();
				foreach ( $messages as $message ) {
					echo $message, "\n";
				}
			} else {
				echo "The batch was deleted successfully!";
			}
		}
		
		$this->view->disable (); // show json data only, no extra html
	}
	
	/*
	 * get a full specific work status
	 */
	public function getAction($qc = null, $work = null, $batch = null) {
		try {
			$w = WorkStatus::findFirst ( [ 
					"qc= :qc: AND work = :work: AND batch = :batch:",
					"bind" => [ 
							"qc" => "$qc",
							"work" => "$work",
							"batch" => "$batch" 
					] 
			] );
			$jsonData = json_encode ( $w );
			echo $jsonData;
			// echo '{"result":"ok","reason":""}';
			$this->view->disable ();
		} catch ( exception $e ) {
			echo '{"result":"failed","reason":"' . $e->getmessage () . '"}';
		}
		$this->view->disable (); // show json data only, no extra html
	}
	
	/*
	 * get a work status' status through qc,work,batch
	 */
	public function getStatusAction($qc = null, $work = null, $batch = null) {
		try {
			if ($qc === null || $work === null || $batch === null) {
				throw new exception ( "Parameters not enough" );
			}
			$w = WorkStatus::findFirst ( [ 
					"qc= :qc: AND work = :work: AND batch = :batch:",
					"bind" => [ 
							"qc" => "$qc",
							"work" => "$work",
							"batch" => "$batch" 
					] 
			] );
			if($w===false){
				throw new exception("reject");
			}
			$rightNow = date ( "Y-m-d H:i:s" );
			if ($rightNow < $w->grantDeadLine || $w->status == "doing") {
				echo "permit"; // if status is 'doing' or grantDeadline not expired grant permit
			}else{
				throw new exception("reject");
			}
		} catch ( exception $e ) {
			echo $e->getMessage ();
		}
		$this->view->disable ();
	}
	
	/*
	 * get all work status of the batch
	 */
	public function getListByBatchAction($batch = null) {
	}
	
	/*
	 * get all work status of the qc
	 */
	public function getListByQcAction($qc = null) {
	}
	
	/*
	 * grant user a work status permission deadline
	 * print a json result
	 */
	public function grantAction($id = null, $grantDeadline = null) {
		try {
			if ($id == null || $grantDeadline == null) {
				throw new exception ( "Parameters not enough" );
			}
			$w = WorkStatus::findFirst ( $id );
			if ($w === false) {
				throw new exception ( "Work status not exist" );
			}
			if ($w->status === "doing") {
				throw new exception ( "No need to grant undone items" );
			}
			$w->grantDeadLine = $grantDeadline;
			$w->update ();
			echo '{"result":"OK"}';
		} catch ( exception $e ) {
			echo '{"result":"' . $e->getmessage () . '"}';
		}
		$this->view->disable ();
	}	
}