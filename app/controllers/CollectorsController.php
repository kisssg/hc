<?php
class CollectorsController extends ControllerBase {
	public function initialize() {
	}
	public function indexAction() {
		echo "index of collectors";
	}
	public function searchAction() {
		$this->view->disable ();
		if ($this->request->isPost ()) {
			$keyword = $this->request->getPost ( 'search' );
			//$keyword="da";
			$suggestion = Collectors::find ( [ 
					"columns" => "id,name_en as value,city as city,area as region, employee_id as employeeID, name_cn as name",
					"conditions" => "name_en like :keyword: or name_cn like :keyword:",
					"limit"=>"10",
					"bind" => [ 
							"keyword" => "$keyword%" 
					] 
			] );
			echo json_encode ( $suggestion );
		}
	}
}