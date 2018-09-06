<?php
use Phalcon\Mvc\Model;
class Collectors extends Model {
	public $id;
	public $Name_CN;
	public $Area;
	public $City;
	public $Position;
	public $Name_EN;
	public $EmployeeID;
	public $OnboardDate;
	public $Email;
	public $Province;
	public $City_CN;
	public $TL;
	public $SV;
	public $Manager;
	public function initialize(){
		$this->setSource ( "fc_employees" );		
	}
}