<?php
class ChartsController extends ControllerBase {
	protected function initialize() {
		$this->tag->setTitle ( "Data Chart" );
		parent::initialize ();
	}
	public function indexAction() {
		echo "dd";
	}
	public function signinAction(){
		$this->session->set('auth', [
				'id' => 1,
				'name' => 'sucre'
		]);
		echo $this->tag->linkto(["../qmtest/test.php","test"]);
	}
	public function uncallAction() {
		
		/*
		 * Method 1 also available;
		 * $connection = $this->db;
		 * $sql = "SELECT distinct(qc_name) as qc,count(is_connected) as count FROM `callback` where is_connected='' and qc_name not in('已删除','sucre xu','scarlett deng') group by qc_name;";
		 * $result = $connection->query ( $sql );
		 * $statics = $result->fetchAll ( $sql );
		 * echo JSON_encode ( $statics );
		 *
		 * but we use this, it's more simple and readable:)
		 */
		$callback = Callback::find ( [ 
				"columns" => "distinct(qc_name) as qc,count(is_connected) as count",
				"conditions" => "(is_connected='' or is_connected='24小时跟踪回拨') and qc_name not in('已删除','sucre xu','scarlett deng')",
				"group" => "qc_name",
				"order" => "count desc"
		] );
		echo JSON_encode ( $callback );
		
		// disable the html code, so only get the JSON string above:)
		$this->view->disable ();
	}
	public function totalcalledAction() {
		$callback = Callback::find ( [ 
				"columns" => "distinct(qc_name) as qc,count(is_connected) as count",
				"conditions" => "is_connected !='' and is_connected !='24小时跟踪回拨' and qc_name not in('fcqc qc','已删除','sucre xu','scarlett deng')",
				"group" => "qc_name" ,
				"order" => "count"
		] );
		echo JSON_encode ( $callback );
		$this->view->disable ();
	}
}