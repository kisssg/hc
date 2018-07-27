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
			$query=new Criteria;
			$query->setDI($this->di);
			$query->setModelName("Journals");
			$query->where("visit_date=:visit_date: ",["visit_date"=>"$visit_date"]);
			if($journal_creator){
				echo "journal_creator";
				$query->andWhere("journal_creator = :journal_creator:",["journal_creator"=>"$journal_creator"]);
			}
			//$query = Criteria::fromInput ( $this->di, "Journals", $this->request->getPost () );
			//at first I was trying to use above method to create the criteria, it works fine,
			//but seems no way to change the "like" to "=", it's slow.
			$this->persistent->SearchParams = $query->getParams ();
		} else {
			$numberPage = $this->request->getQuery ( "page", "int" );
		}
		
		$parameters = array ();
		if ($this->persistent->SearchParams) {
			$parameters = $this->persistent->SearchParams;
		}else{
			$parameters=["j_id=100"];
		}
		$journals = Journals::find ( $parameters );
		if (count ( $journals ) == 0) {
			// $this->flash->notice("The search did not find any products");
			echo "nothing find.";
			//return;
		}
		
		$paginator = new Paginator ( array (
				"data" => $journals,
				"limit" => 10,
				"page" => $numberPage 
		) );
		
		$this->view->page = $paginator->getPaginate ();
	}
}