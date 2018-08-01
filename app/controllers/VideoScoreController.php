<?php
class videoScoreController extends ControllerBase{
	public function initialize(){
		
	}
	public function addAction($qc){
		$score=new VideoScores;
		$score->QC=$qc;
		$score->save();
		echo $qc." added!";
	}
	public function deleteAction($id){
		
	}
	public function updateAction($id){
		
	}
	public function showAction(){
		
	}
}