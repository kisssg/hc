<?php
class MysterymonitorController extends ControllerBase {
	public function indexAction() {
	}
	public function initialize() {
	}
	public function getLCSAction() {
		$this->view->disable ();
		$agency = $this->request->getPost ( "agency" );
		$agency = 'dechuangrong';
		$LCS = Agencies::findFirst ( [ 
				"agency= :agency:",
				"bind" => [ 
						"agency" => "$agency" 
				] 
		] );
		if ($LCS) {
			echo $LCS->LCS;
		}
	}
}