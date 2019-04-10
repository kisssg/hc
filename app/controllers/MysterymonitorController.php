<?php
class MysterymonitorController extends ControllerBase {
	public function indexAction() {
	}
	public function initialize() {
	}
	public function getLCSAction() {
		$this->view->disable ();
		$agency = $this->request->getPost ( "agency" );
		// $agency = 'dechuangrong';
		$LCS = Agencies::findFirst ( [ 
				"agency= :agency:",
				"bind" => [ 
						"agency" => "$agency" 
				] 
		] );
		if ($LCS) {
			echo $LCS->LCS;
		} else {
			echo "无匹配";
		}
	}
	public function saveRemarkAction() {
		$this->view->disable();
		try {
			$remark = $this->request->getPost ( 'remark' );
			$id = $this->request->getPost ( 'id' );
			$contract = FakeContracts::findFirst ( $id );
			$contract->remark = $remark;
			if ($contract->save () === true) {
				echo '{"result":"success","msg":""}';
			} else {
				throw new exception("Failed saving remark.");
			}
		} catch ( Exception $e ) {
			echo '{"result":"failed","msg":"'.$e->getMessage().'"}';
		}
	}
}