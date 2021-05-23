<?php
class BaseDAO
{
	static function executeSelect($cwrap, $sql) {
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
        $sql = str_replace("{pre}", $ds['prefix'], $sql);
//        var_export ($sql);
//        var_export ($params);
        $conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = $conn->Execute($sql);
        $cwrap->stmts[] = array($sql,$sw->stop());
		return $rs;
	}
	
	static function executeStatement($cwrap, $sql, $params=false) {
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
        $sql = str_replace("{pre}", $ds['prefix'], $sql);
//        var_export ($sql);
//        var_export ($params);
        $conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$stmt = $conn->Prepare($sql);
		$rs = $conn->Execute($stmt, $params);
		return $rs;
	}
	
	static function executeSelectLimit($cwrap, $sql, $params, $numrows=1, $offset=0) {
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
        $sql = str_replace("{pre}", $ds['prefix'], $sql);
//        echo $sql;
//        echo "<br>";
//        var_export ($params);
        $conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$stmt = $conn->Prepare($sql);
		$rs = $conn->SelectLimit($stmt, $numrows, $offset, $params);
//		var_export($rs);
        $cwrap->stmts[] = array($sql,$sw->stop());
		return $rs;
	}
	
	static function genId($cwrap, $seq) {
		$conn = $cwrap->conn;
		$ds = $cwrap->ds;
		$gen = $ds['id_generator'];
		if ($gen == 'adodb') {
        	$id = $conn->GenID($seq);
		}
		else if ($gen == 'autoincrement') {
			$id = 0;
		}
		else if ($gen == 'uniqid') {
			$prefix = 'ID-'.$_SERVER['SERVER_NAME'].'-'.$_SERVER['SERVER_PORT'].'-'; 
			$id = uniqid($prefix,true);
		}
        return $id;
   }
}
?>