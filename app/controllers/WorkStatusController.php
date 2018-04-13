<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
class WorkStatusController extends ControllerBase {
	protected function initialize() {
		$this->tag->setTitle ( "WorkStatus" );
	}
	public function indexAction() {
		$this->dispatcher->forward ( [ 
				'action' => 'items' 
		] );
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
	public function getPermissionAction($qc = null, $work = null, $batch = null) {
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
			if ($w === false) {
				throw new exception ( "reject" );
			}
			$rightNow = date ( "Y-m-d H:i:s" );
			if ($rightNow < $w->grantDeadLine || $w->status == "doing") {
				echo "permit"; // if status is 'doing' or grantDeadline not expired grant permit
			} else {
				throw new exception ( "reject" );
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
			
			// check if user is allowed to do the grant action;
			$level = $this->session->auth ['level'];
			if ($level < 11) {
				throw new exception ( "Not authorized" );
			}
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
	public function itemsAction($work = null, $batch = null) {
		try {
			// Current page to show
			// In a controller/component this can be:
			// $this->request->getQuery("page", "int"); // GET
			// $this->request->getPost("page", "int"); // POST
			$currentPage = $this->request->getQuery ( "page", "int" );
			if ($work == null || $batch == null) {
				throw new exception ( "parameters not enough" );
			}
		} catch ( exception $e ) {
			echo $e->getmessage ();
			$this->view->disable ();
		}
		$criteria = [ 
				"work = :work: AND batch = :batch:",
				"bind" => [ 
						"work" => "$work",
						"batch" => "$batch"
				] ,
				"order" => "status,donetime"
		];
		
		// The data set to paginate
		
		$workstatus = WorkStatus::find ( $criteria );
		// Create a Model paginator, show 10 rows by page starting from $currentPage
		$paginator = new PaginatorModel ( [ 
				"data" => $workstatus,
				"limit" => 50,
				"page" => $currentPage 
		] );
		
		// Get the paginated results
		$page = $paginator->getPaginate ();
		echo "<table class='contracts' style='width:auto;'>
		<tr>
		<th>No.</th>
		<th>QC</th>
		<th>Work</th>
		<th>Batch</th>
		<th>Status</th>
		<th>DoneTime</th>
		<th>Action</th>
		</tr>";
		$i=0;
		foreach ( $page->items as $item ) {
			if ($item->grantDeadLine > date ( "Y-m-d H:i:s" )) {
				$status = "granting";
			} else {
				$status = $item->status;
			}
			$i++;
			echo "<tr>
        <td>" . $i. "</td>" . "
        <td>" . $item->qc . "</td>
        <td>" . $item->work . "</td>
        <td>" . $item->batch . "</td>
		<td>" . $status . "</td>
		<td>" . $item->donetime . "</td>
		<td><button class='btn btn-default btn-xs' onclick='return WorkStatus.grant(" . $item->id . ")'>Grant</button></td>
    	</tr>";
		}
		echo "</table>";
		echo '<div class="clearfix pagination">
	<a class="number" href="?page=1">&laquo;</a>' . '
	<a class="number" href="?page=' . $page->before . '">&lsaquo;</a>
	<a class="number" href="?page=' . $page->next . '">&rsaquo;</a>
	<a class="number" href="?page=' . $page->last . '">&raquo;</a>
	</div>
	' . $page->current, "/", $page->total_pages;
		echo $this->tag->javascriptInclude ( 'js/moment.min.js' );
		echo $this->tag->javascriptInclude ( 'js/workstatus.js' );
	}
}