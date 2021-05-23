<?php
include_once('connection_wrapper.php');
include_once('db_util.php');

/**
		$cwrap->conn->StartTrans();
		$cwrap->conn->CompleteTrans();

 		$cwrap->conn->MetaTables(); 
*/
class DBConnection
{
	const BASIC = 'basic';
	const POOL = 'pool';

	static $connWrappers = array();
		
	private function __construct() {}

	static function open($db) {
		$cwrap = null;
		$conn = null;
		$ds = DBConnection::getDatasource($db);
		if (!isset(DBConnection::$connWrappers[$db])) { 
			$cwrap = new ConnectionWrapper();
			$cwrap->ds = $ds;
			$cwrap->db = $db;
//			if ($ds['use_pool'] == true) {
//				$conn = DBConnection::getPoolConnection($db, $ds);
//				$cwrap->type = DBConnection::POOL;
//			}
//			else  {
			$conn = DBConnection::getBasicConnection($ds);
				$cwrap->type = DBConnection::BASIC;
//			}
				$cwrap->conn = $conn;
			DBConnection::$connWrappers[$db] = $cwrap;
		}
		else {
			$cwrap = DBConnection::$connWrappers[$db];
		}
		
		return $cwrap;
	}
	
	static function close($cwrap) {
		switch ($cwrap->type) {
			case DBConnection::POOL:
			case DBConnection::BASIC:
			default:
				break;
		}

//		Log::debug('Total time: ' . $time . '<br>');
//		
//		for ($i=0; $i<count($cwrap->stmts); $i++) {
//			Log::debug($cwrap->stmts[$i] . ' : ' . $cwrap->times[$i] . '<br>');
//		}
	}

	static function cleanup() {
		foreach (DBConnection::$connWrappers as $db => $cwrap) {
			if ($cwrap->type == DBConnection::POOL) {
				$conn = $cwrap->conn;
				DBConnection::returnPoolConnection($db, $conn);
			}			
		}
	}
		
	static function getBasicConnection($ds) {
		$dsn = $ds['dsn'];
		$conn = ADONewConnection($dsn);
		if (!$conn) {
			throw new DatabaseConnectionException();
		}
		return $conn;  
	}
	
	static function getPoolConnection($db, $ds) {
		$poolAvail = true;
		
		$filename = DBConnection::genPoolname($db);
		try {
			$pool = Serialize::fromFile($filename);
			if (count($pool) == 0) {
				$poolAvail = false;
			}
			else {
				$conn = array_pop($pool);	
				Serialize::toFile($filename, $pool);
			}
		}
		catch (Exception $e) {
			$poolAvail = false;
		}
		
		if (!$poolAvail) {
			$conn = DBConnection::getBasicConnection($ds);
		}
		
		if (!$conn) {
			throw new DatabaseConnectionException();
		}
		return $conn;  
	}

	static function returnPoolConnection($db, $conn) {
		$filename = DBConnection::genPoolname($db);
		try {
			$pool = Serialize::fromFile($filename);
			array_push($pool, $conn);	
			Serialize::toFile($filename, $pool);
		}
		catch (FileDoesNotExistException $ne) {
			$pool = array();
			array_push($pool, $conn);	
			Serialize::toFile($filename, $pool);
		}
	}
	
	static function getDatasource($db) {
		global $PW;
		
		$map = $PW['db']['map'][$db];
		$ds = $PW['db']['datasource'][$map];
		
		if ($ds == null) {
			throw new DatasourceDoesNotExistException($db);
		}
		
		return $ds;
	}

	static function genPoolname($db) {
		$filename = DBConnection::POOL.'-'.$db.'-'.DBUtil::getSiteDB();
		return $filename;		
	}	
}
?>