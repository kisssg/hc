<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class JournalsController extends ControllerBase {
	public function initialize() {
	}
	public function indexAction() {
	}
	public function searchAction() {
		$numberPage = 1;
		if ($this->request->isPost ()) {
			$visit_date= $this->request->getPost ('visit_date','string');
			$journal_creator= $this->request->getPost ('journal_creator','string');
			$contract_no= $this->request->getPost ('contract_no','string');
			$query=new Criteria;
			$query->setModelName("Journals");
			$query->where("1=1");
			$hasRequest=false;
			if($visit_date){
				$query->andWhere("visit_date=:visit_date: ",["visit_date"=>"$visit_date"]);
				$hasRequest=true;				
			}
			if($journal_creator){
				$query->andWhere("journal_creator like :journal_creator:",["journal_creator"=>"$journal_creator%"]);
				$hasRequest=true;
			}
			if($contract_no){
				$query->andWhere("contract_no = :contract_no:",["contract_no"=>"$contract_no"]);
				$hasRequest=true;
			}
			//$query1 = Criteria::fromInput ( $this->di, "Journals", $this->request->getPost () );
			$this->persistent->searchParams = $query->getParams ();
		} else {			
			$hasRequest=true;
			$numberPage = $this->request->getQuery ( "page", "int" );
		}
		
		$parameters = array ();
		if ($this->persistent->searchParams && $hasRequest) {
			$parameters = $this->persistent->searchParams;
		}else{
			$parameters=["j_id=100"];
		}
		$journals = Journals::find ( $parameters );
		if (count ( $journals ) == 0) {
			 $this->flash->notice("The search did not find any journals");
		}
		
		$paginator = new Paginator ( array (
				"data" => $journals,
				"limit" => 10,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
}