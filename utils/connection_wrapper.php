<?php
include_once('db_util.php');

class ConnectionWrapper
{
	public $db;
	public $type; // basic, pool
	public $ds;
	public $conn;
	public $instId;
	public $stmts = array();
	public $stopwatch;
	
	function __construct() {
		global $PW;
		$this->instId = DBUtil::getInstId();				
	}
}
?>