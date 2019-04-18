<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxRead;
class IssuesController extends ControllerBase {
	public function initialize() {
	}
	public function indexAction() {
		echo "<a href='issues/getList'>" . "List" . "</a>";
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello Sucre.xu !');
		
		$writer = new Xlsx($spreadsheet);
		$rndNo=random_int(5,1000);
		$file='D:\UPUPW_NP7.2_64\htdocs\uploadfiles\hello world'.$rndNo.'.xlsx';
		$writer->save($file);
		header("location:../uploadfiles/hello world".$rndNo.".xlsx");
	}
	public function addAction() {
		echo 'add';
	}
	public function delAction() {
		echo 'del';
	}
	public function getAction($id) {
		if (is_numeric ( $id )) {
			$issue = Issues::findFirst ( $id );
			if ($issue == null) {
				echo '数据不存在';
				return;
			}
			foreach ( $issue as $item ) {
				echo $item, '<br/>';
			}
		}
	}
	public function getListAction() {
		echo 'getList';
	}
	/*
	 * Violations
	 */
	public function addViolationAction() {
		// add a violation base on an valid issue;
		echo 'addViolation';
	}
	public function delViolationAction() {
		// delete a specific violation;
		echo 'delViolation';
	}
	public function getViolationAction() {
		// get a specific violation;
		echo 'getViolation';
	}
	public function getViolationsAction() {
		// get a collection of violations meet requirements;
		echo 'getViolation';
	}
	
	/*
	 * Punishments
	 */
	public function getPunishmentAction() {
		echo 'getPunishment';
	}
	public function getPunishmentsAction() {
		echo 'getPunishments';
	}
	public function addPunishmentAction() {
		echo 'addPunishment';
	}
	public function delPunishmentAction() {
		echo 'delPunishment';
	}
}