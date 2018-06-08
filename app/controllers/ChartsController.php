<?php
class ChartsController extends ControllerBase {
	protected function initialize() {
		$this->tag->setTitle ( "Data Chart" );
		parent::initialize ();
	}
	public function indexAction() {
		$this->view->setTemplateBefore ( 'public' );
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
		 * but we use this, it's more readable:)
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
				"order" => "total",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function harassRecievedAction() {
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$group = Callback::find ( [ 
				"columns" => "distinct(qc_name) as qc,COUNT(*) as total,count(nullif('Y 是',is_harassed)) as noharass",
				"conditions" => "(check_time between :startDate: and :endDate:) and qc_name not in('已删除')",
				"group" => "qc_name",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function workStatusAction($batch) {
		
		/*
		 * $startDate = $this->request->getPost ( "startDate" );
		 * $endDate = $this->request->getPost ( "endDate" );
		 */
		$group = WorkStatus::find ( [ 
				"columns" => "qc,createtime,donetime,remark",
				"conditions" => "batch = :batch:",
				"group" => "qc",
				"bind" => [ 
						"batch" => "$batch" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function visitCheckAction() {
		$this->view->setTemplateBefore ( 'public' );
		$this->tag->setTitle('Visit Check');
		
	}
	public function issuesAction() {
		$this->view->setTemplateBefore ( 'public' );
	}
	public function issueTypeAction() {
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$group = Issues::find ( [ 
				"columns" => "distinct(issue) as type,count(issue) as count",
				"conditions" => "add_time between :startDate: and :endDate: and result != '无效'",
				"group" => "type",
				"order" => "count desc",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function harassmentTypeAction() {
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$group = Issues::find ( [ 
				"columns" => "distinct(harassment_type) as type,count(issue) as count",
				"conditions" => "add_time between :startDate: and :endDate: and result != '无效'",
				"group" => "type",
				"order" => "count",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function issueQCOverviewAction() {
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$group = Issues::find ( [ 
				"columns" => "distinct(qc_name) as type,count(issue) as count",
				"conditions" => "add_time between :startDate: and :endDate: and result != '无效'",
				"group" => "type",
				"order" => "count",
				"bind" => [ 
						"startDate" => "$startDate",
						"endDate" => "$endDate" 
				] 
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function checkEfficiencyAction(){
		$startDate = $this->request->getPost ( "startDate" );
		$endDate = $this->request->getPost ( "endDate" );
		$group = Journals::find ( [
				"columns" => "distinct(qc_name) as qc,validity,avg(checking_time) as avgSecCost",
				"conditions" => "visit_date between :startDate: and :endDate: and qc_name != 'tool'",
				"group" => "qc_name,validity",
				"order" => "qc_name,validity",
				"bind" => [
						"startDate" => "$startDate",
						"endDate" => "$endDate"
				]
		] );
		echo json_encode ( $group );
		$this->view->disable ();
	}
	public function checkEfficiencyAllAction(){
		$startDate=$this->request->getPost("startDate");
		$endDate=$this->request->getPost("endDate");//"2018-06-05";//
		$group= Journals::find([
				"columns"=>"distinct(validity) as validity,avg(checking_time) as avgSecCost",
				"conditions"=>"visit_date between :startDate: and :endDate: and qc_name != 'tool'",
				"group"=>"validity",
				"order"=>"validity",
				"bind"=>[
						"startDate"=>"$startDate",
						"endDate"=>"$endDate"
				]
		]);
		echo json_encode($group);
		$this->view->disable();
	}
	
	public function outsourcingAction(){
		$this->view->setTemplateBefore ( 'public' );		
	}
	public function cntRecordingAction(){
		$startDate=$this->request->getPost("startDate");
		$endDate=$this->request->getPost("endDate");
		/* test value
		$startDate="2018-06-01";
		$endDate="2018-06-05";*/
		$group=SilentMonitorAssessments::find([
				"columns"=>"distinct(QC) as qc,count(QC) as count,FORMAT(avg(seconds),2) as avgDuration",
				"conditions"=>"create_time between :startDate: and :endDate: and qc != 'public.osv'",
				"group"=>"QC",
				"order"=>"count",
				"bind"=>[
						"startDate"=>"$startDate",
						"endDate"=>"$endDate"
				]
		]);
		$value1=[
				"qc"=>"team",
				"count"=>100,
				"avgDuration"=>150
		];
		$arr=array();
		foreach($group as $item){
			$arr1=(array)$item;
			array_push($arr,$arr1);
		}
		$result=$this->cntRecordingTeam($startDate, $endDate);
		array_push($arr, $result);
		echo json_encode($arr);
		$this->view->disable();
	}
	private function cntRecordingTeam($startDate,$endDate){
		$group=SilentMonitorAssessments::find([
				"columns"=>"count(*) as count,FORMAT(avg(seconds),2) as avgDuration",
				"conditions"=>"create_time between :startDate: and :endDate:  and QC != 'public.osv'",
				"order"=>"count",
				"bind"=>[
						"startDate"=>"$startDate",
						"endDate"=>"$endDate"
				]
		]);
		foreach($group as $item){
			$result=(array)$item;
		}
		$result['qc']="Team";
		return($result);
	}
	public function cntContractsAction(){
		$startDate=$this->request->getPost("startDate");
		$endDate=$this->request->getPost("endDate");//"2018-06-05";//
		$group=SilentMonitorContracts::find([
				"columns"=>"distinct(qc_name) as qc, count(*) as count,count(nullif(0,assess_count)) as checked ",
				"conditions"=>"checking_date between :startDate: and :endDate:  and qc_name != 'public.osv'",
				"group"=>"qc",
				"bind"=>[
						"startDate"=>"$startDate",
						"endDate"=>"$endDate"
				]
		]);
		echo json_encode($group);
		$this->view->disable();
	}
	public function cntContractsAllAction(){		
		$startDate=$this->request->getPost("startDate");
		$endDate=$this->request->getPost("endDate");//"2018-06-05";//
		/* $startDate="2018-06-01";
		$endDate="2018-06-09"; */
		$group=SilentMonitorContracts::find([
		"columns"=>"count(*) as count,count(nullif(0,assess_count)) as checked ",
		"conditions"=>"checking_date between :startDate: and :endDate: and qc_name != 'public.osv'",
		"bind"=>[
				"startDate"=>"$startDate",
				"endDate"=>"$endDate"
		]
		]);
		echo json_encode($group);
		$this->view->disable();		
	}
	public function mysteryContractsAction(){
		/* $startDate="2018-06-01";
		 $endDate="2018-06-09"; */
		$group=FakeContracts::find([
				"columns"=>"distinct(qc) as qc,count(*) as count,count(nullif(0,assess_count)) as checked ",
				"group"=>"qc",
				"order"=>"count",
				"conditions"=>"qc != 'public.osv'"
		]);
		echo json_encode($group);
		$this->view->disable();				
	}
	PUBLIC function mysteryAssessAction(){
		$startDate=$this->request->getPost("startDate");
		$endDate=$this->request->getPost("endDate");//"2018-06-05";//
		/* $startDate="2018-06-01";
		$endDate="2018-06-09"; */
		$group=MysteryScores::find([
				"columns"=>"distinct(qc) as qc,count(*) as count",
				"conditions"=>"create_time between :startDate: and :endDate: and qc != 'public.osv'",
				"group"=>"qc",
				"order"=>"count desc",
				"bind"=>[
						"startDate"=>"$startDate",
						"endDate"=>"$endDate"
				]
		]);
		echo json_encode($group);
		$this->view->disable();		
		
	}
}