<?php

use Phalcon\Mvc\Model;

class User extends Model{
	public $id;
	public $username;
	public $email;
	public $level;
	public $status;
}