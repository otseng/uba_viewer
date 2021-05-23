<?php
include_once('base_dao.php');
include_once('exceptions.php');
include_once('uba_html_content_mo.php');

class UbaHtmlContentDAO extends BaseDAO
{
	const TABLE_NAME = 'uba_html_content';

	const HTML_CONTENT_ID = 'html_content_id';
	const CODE = 'code';
	const CONTENT = 'content';
	const ADD_USER_ID = 'add_user_id';
	const ADD_DATETIME = 'add_datetime';
	const INST_ID = 'inst_id';

	static function countAll($cwrap) {
		$conn = $cwrap->conn;
		$sql = 'select count(*) as count from {pre}'.UbaHtmlContentDAO::TABLE_NAME.
			' where '.
			UbaHtmlContentDAO::INST_ID.'='.$conn->Param('a');
		$rs = BaseDAO::executeStatement($cwrap, $sql, array($cwrap->instId));
		$count = $rs->fields['count'];
		return $count;
	}

	static function create($cwrap, $object) {
		$object->setup();
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
		if ($object->addUserId == null) {
			$object->addUserId = '';
		}
		if ($object->addDatetime == null) {
			$datetime = $conn->DBTimeStamp(time());
			$datetime = stripslashes($datetime);
			$datetime = str_replace("'","",$datetime);
			$object->addDatetime = $datetime;
		}
		if ($object->htmlContentId == null) {
			$id = BaseDAO::genId($cwrap, UbaHtmlContentDAO::HTML_CONTENT_ID);
			$object->htmlContentId = $id;
		}
		if ($object->instId == null) {
			$object->instId = $cwrap->instId;
		}
		$sql = 'insert into {pre}'.UbaHtmlContentDAO::TABLE_NAME.' ('.
			UbaHtmlContentDAO::HTML_CONTENT_ID.','.
			UbaHtmlContentDAO::CODE.','.
			UbaHtmlContentDAO::CONTENT.','.
			UbaHtmlContentDAO::ADD_USER_ID.','.
			UbaHtmlContentDAO::ADD_DATETIME.','.
			UbaHtmlContentDAO::INST_ID.
			') values ('.
			$conn->Param('a').','.
			$conn->Param('b').','.
			$conn->Param('c').','.
			$conn->Param('d').','.
			$conn->Param('e').','.
			$conn->Param('f').
			')';
		$result = null;
		try {
			$result = BaseDAO::executeStatement($cwrap, $sql,
			  array(
			$object->htmlContentId,
			$object->code,
			$object->content,
			$object->addUserId,
			$object->addDatetime,
			$object->instId
			));
		}
		catch (Exception $e) {
			throw new DatabaseRecordCreationException($conn->_errorMsg);
		}
		return $object;
	}

	static function retrieveAll($cwrap) {
		$list = array();
		$conn = $cwrap->conn;
		$sql = 'select * from {pre}'.UbaHtmlContentDAO::TABLE_NAME.
			' where '.
			UbaHtmlContentDAO::INST_ID.'='.$conn->Param('a');
		$rs = BaseDAO::executeStatement($cwrap, $sql, array($cwrap->instId));
		while (!$rs->EOF) {
			$list[] = UbaHtmlContentDAO::buildObject($rs->fields);
			$rs->MoveNext();
		}
		return $list;
	}

	static function retrieveById($cwrap, $id) {
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
		$sql = 'select * from {pre}'.UbaHtmlContentDAO::TABLE_NAME.
			' where '.
			UbaHtmlContentDAO::HTML_CONTENT_ID.'='.$conn->Param('a').' and '.
			UbaHtmlContentDAO::INST_ID.'='.$conn->Param('b');
		$rs = BaseDAO::executeStatement($cwrap, $sql, array($id, $cwrap->instId));
		if ($rs->EOF) {
			throw new DatabaseRecordNotFoundException();
		}
		$object = UbaHtmlContentDAO::buildObject($rs->fields);	
		return $object;
	}

	static function retrieveByCode($cwrap, $code) {
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
		$sql = 'select * from {pre}'.UbaHtmlContentDAO::TABLE_NAME.
			' where '.
			UbaHtmlContentDAO::CODE.'='.$conn->Param('a').' and '.
			UbaHtmlContentDAO::INST_ID.'='.$conn->Param('b');
		$rs = BaseDAO::executeStatement($cwrap, $sql, array($code, $cwrap->instId));
		if ($rs->EOF) {
			throw new DatabaseRecordNotFoundException();
		}
		$object = UbaHtmlContentDAO::buildObject($rs->fields);	
		return $object;
	}

	static function retrievePage($cwrap, $numrows, $offset, $sortCol = null, $sortDir = null) {
		$list = array();
		$conn = $cwrap->conn;
		$sql = 'select * from {pre}'.UbaHtmlContentDAO::TABLE_NAME.
			' where '.
			UbaHtmlContentDAO::INST_ID.'='.$conn->Param('a');
		if ($sortCol != null) {
			$sql .= ' order by '.$sortCol;
		}
		if ($sortDir == -1) {
			$sql .= ' desc';
		}
		$rs = BaseDAO::executeSelectLimit($cwrap, $sql, array($cwrap->instId), $numrows, $offset);
		while (!$rs->EOF) {
			$list[] = UbaHtmlContentDAO::buildObject($rs->fields);
			$rs->MoveNext();
		}
		return $list;
	}

	static function update($cwrap, $object) {
		$object->setup();
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
		$sql = 'update {pre}'.UbaHtmlContentDAO::TABLE_NAME.' set '.
			UbaHtmlContentDAO::CODE.'='.
			$conn->Param('b').','.
			UbaHtmlContentDAO::CONTENT.'='.
			$conn->Param('c').','.
			UbaHtmlContentDAO::ADD_USER_ID.'='.
			$conn->Param('d').','.
			UbaHtmlContentDAO::ADD_DATETIME.'='.
			$conn->Param('e').','.
			UbaHtmlContentDAO::INST_ID.'='.
			$conn->Param('f').
			' where '.
			UbaHtmlContentDAO::HTML_CONTENT_ID.'='.
			$conn->Param('g');
		try {
			$result = BaseDAO::executeStatement($cwrap, $sql,
		  	array(
			    $object->code,
			    $object->content,
			    $object->addUserId,
			    $object->addDatetime,
			    $object->instId,
				$object->htmlContentId
			));
		}
		catch (Exception $e) {
			throw new DatabaseRecordUpdateException($conn->_errorMsg);
		}
		return $object;
	}

	static function deleteById($cwrap, $id) {
		$ds = $cwrap->ds;
		$conn = $cwrap->conn;
		$sql = 'delete from {pre}'.UbaHtmlContentDAO::TABLE_NAME.
			' where '.
			UbaHtmlContentDAO::HTML_CONTENT_ID.'='.$conn->Param('a').' and '.
			UbaHtmlContentDAO::INST_ID.'='.$conn->Param('b');
		$result = BaseDAO::executeStatement($cwrap, $sql, array($id, $cwrap->instId));
		return $result;
	}

	static function buildObject($fields) {
		$object = new UbaHtmlContentMO();
		$object->htmlContentId = $fields[UbaHtmlContentDAO::HTML_CONTENT_ID];
		$object->code = $fields[UbaHtmlContentDAO::CODE];
		$object->content = $fields[UbaHtmlContentDAO::CONTENT];
		$object->addUserId = $fields[UbaHtmlContentDAO::ADD_USER_ID];
		$object->addDatetime = $fields[UbaHtmlContentDAO::ADD_DATETIME];
		$object->instId = $fields[UbaHtmlContentDAO::INST_ID];
		return $object;
	}

	static function getColumns() {
		$cols = array(
	    	UbaHtmlContentDAO::HTML_CONTENT_ID,
	    	UbaHtmlContentDAO::CODE,
	    	UbaHtmlContentDAO::CONTENT,
	    	UbaHtmlContentDAO::ADD_USER_ID,
	    	UbaHtmlContentDAO::ADD_DATETIME,
	    	UbaHtmlContentDAO::INST_ID,
		);
		return $cols;
	}
}
?>
