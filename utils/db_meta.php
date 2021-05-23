<?php
include_once('db_connection.php');

class DBMeta
{
	static function getTables($map='pw') {
		$cwrap = DBConnection::open($map);
		$tables = $cwrap->conn->MetaTables('TABLES');
		DBConnection::close($cwrap);
		return $tables;
	}

	static function getColumnNames($table, $map='pw') {
		$cwrap = DBConnection::open($map);
		$cols = $cwrap->conn->MetaColumnNames($table, true);
		DBConnection::close($cwrap);
		return $cols;
	}
}
?>