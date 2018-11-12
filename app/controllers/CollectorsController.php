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
			$keyword="da";
			$suggestion = Collectors::find ( [ 
					"columns" => "id,Name_EN as value,City as city,Area as region, EmployeeID as employeeID",
					"conditions" => "Name_EN like :keyword: ",
					"limit"=>"10",
					"bind" => [ 
							"keyword" => "$keyword%" 
					] 
			] );
			echo json_encode ( $suggestion );
		}
	}
}