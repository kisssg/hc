<?php
class ChartsController extends ControllerBase {
	protected function initialize() {
		$this->tag->setTitle ( "Data Chart" );
		parent::initialize ();
	}
	public function indexAction() {
		echo "dd";
	}
	public function signinAction() {
		echo $this->tag->linkto ( [ 
				"../qmtest/test.php",
				"test" 
		] );
	}
	public function uncallAction() {
		
		/*
		 * Method 1 also available;
		 * $connection = $this->db;
		 * $sql = "SELECT distinct(qc_name) as qc,count(is_connected) as count
		 * FROM `callback` where is_connected='' and qc_name not in('已删除','sucre
		 * xu','scarlett deng') group by qc_name;";
		 * $result = $connection->query ( $sql );
		 * $statics = $result->fetchAll ( $sql );
		 * echo JSON_encode ( $statics );
		 *
		 * but we use this, it's more simple and readable:)
		 */
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		
		$callback = Callback::find ( [ 
				"columns" => "distinct(qc_name) as qc,count(is_connected) as count",
				"conditions" => "upload_time between :startDate: and :endDate: and (is_connected='' or is_connected='24小时跟踪回拨') and qc_name not in('已删除','sucre xu','scarlett deng')",
				"group" => "qc_name",
				"order" => "count desc",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo JSON_encode ( $callback );
		
		// disable the html code, so only get the JSON string above:)
		$this->view->disable ();
	}
	public function totalcalledAction() {
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$callback = Callback::find ( [ 
				"columns" => "distinct(qc_name) as qc,COUNT(NULLIF('', is_connected)) as called,count(*) as total,count(nullif('接通',is_connected)) as unconnected",
				"conditions" => "upload_time between :startDate: and :endDate: and qc_name not in('fcqc qc','已删除','sucre xu','scarlett deng')",
				"group" => "qc_name",
				"order" => "total",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo JSON_encode ( $callback );
		$this->view->disable ();
	}
	public function dingCheckAction() {
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$group = Journals::find ( [ 
				"columns" => "distinct(qc_name) as qc,count(qc_name) as total,count(nullif('',validity)) as checked, count(nullif('A',validity)) as NA,count(nullif('B',validity)) as NB,count(nullif('C',validity)) as NC,count(nullif('D',validity)) as ND",
				"conditions" => "visit_date between :startDate: and :endDate: and qc_name != 'tool'",
				"group" => "qc_name",
				"order"=>"total",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate"=>"$endDate"
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function dingUncheckedAction($visitDate) {
		$group = Journals::count ( [ 
				"column" => "qc_name",
				"conditions" => "visit_date= :visitDate: and validity =''",
				"group" => "qc_name",
				"bind" => [ 
						"visitDate" => "$visitDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function harassRecieveRateAction() {
		
		/*
		 * $startDate = $this->request->getPost ( "startDate" );
		 * $endDate = $this->request->getPost ( "endDate" );
		 */
		$startDate = '2018-05-01';
		$endDate = '2018-05-09';
		$group = Callback::find ( [ 
				"columns" => "distinct(qc_name),COUNT(*),count(nullif('Y 是',is_harassed))",
				"conditions" => "(check_time between :startDate: and :endDate:)",
				"group" => "qc_name",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function visitCheckAction() {
	}
}