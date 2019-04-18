<?php
use Phalcon\Mvc\Model;
class Authorities extends Model{
	public $id;
	public $authority;
	public $module;
	public $user;
}