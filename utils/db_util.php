<?php
class DBUtil
{
	/*
	 * Set timestamp in a String field
	 * <field name="last_login" type="C" size="25">
	 * $fbMO->lastLogin = DBUtil::now();
	 */
	static function now() {
		return "'".date("Y-m-d H:i:s")."'";
	}
	
	static function getInstId() {
		global $PW, $USER;
		
		if (isset($USER['setting']['inst_id'])) {
			return $USER['setting']['inst_id'];
		}
		else if (isset($PW['setting']['inst_id'])) {
			return $PW['setting']['inst_id'];
		}
		else {
			return $PW['default']['inst_id'];
		}
	}
	
	static function getSiteDB() {
		global $PW, $USER;
		
		if (isset($USER['setting']['site_db'])) {
			return $USER['setting']['site_db'];
		}
		else if (isset($PW['setting']['site_db'])) {
			return $PW['setting']['site_db'];
		}
		else {
			return $PW['default']['site_db'];
		}
	}	

	static function dumpStmts() {	
		global $PW;
		
		$s = '';
		if (isset($PW['db']['map'])) {
			foreach ($PW['db']['map'] as $key=>$value) {
				$cwrap = DBConnection::open($key);
				$stmts = $cwrap->stmts;	
				$s .= '<br>'.$key.' SQL Stmts: '.count($stmts);
				for ($i = 0; $i<count($stmts); $i++) {
					$s .= '<br>'.$stmts[$i][1].' - '.$stmts[$i][0];	
				}
				DBConnection::close($cwrap);
			}
		}
		return $s;
	}

	static function getTotalCount() {	
		global $PW;
		
		$count = 0;
		
		if (isset($PW['db']['map'])) {
			foreach ($PW['db']['map'] as $key=>$value) {
				$cwrap = DBConnection::open($key);
				$stmts = $cwrap->stmts;	
				$count += count($stmts);
				DBConnection::close($cwrap);
			}
		}
		return $count;
	}
}
?>