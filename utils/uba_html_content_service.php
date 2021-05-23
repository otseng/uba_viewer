<?php
include_once('db_connection.php');
include_once('uba_html_content_dao.php');

class UbaHtmlContentService
{
	const MAP = 'pw';
	const CACHE_UBA_HTML_CONTENT = 'uba_html_content';

	static function refreshCache() {
//		$cacheName = Cache::genName(UbaHtmlContentService::CACHE_UBA_HTML_CONTENT,UbaHtmlContentService::MAP);
//		Cache::refresh($cacheName);
	}

	static function countAll() {
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);
		$count = UbaHtmlContentDAO::countAll($cwrap);
		DBConnection::close($cwrap);
		return $count;
	}

	static function create($object) {
		if (get_class($object) != 'UbaHtmlContentMO') {
			throw new WrongClassException(get_class($object).'->UbaHtmlContentMO');
		}
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);
		$object = UbaHtmlContentDAO::create($cwrap, $object);
		DBConnection::close($cwrap);

		UbaHtmlContentService::refreshCache();

		return $object;
	}

	static function retrieveAll() {
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);
		$list = UbaHtmlContentDAO::retrieveAll($cwrap);
		DBConnection::close($cwrap);
		return $list;
	}

	static function retrieveById($id) {
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);
		$object = UbaHtmlContentDAO::retrieveById($cwrap, $id);
		DBConnection::close($cwrap);
		return $object;
	}

	static function retrieveByCode($code) {
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);
		$object = UbaHtmlContentDAO::retrieveByCode($cwrap, $code);
		DBConnection::close($cwrap);
		return $object;
	}

	static function retrievePage($numrows, $offset, $sortCol=null, $sortDir=null) {
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);
		$object = UbaHtmlContentDAO::retrievePage($cwrap, $numrows, $offset, $sortCol, $sortDir);
		DBConnection::close($cwrap);
		return $object;
	}

	static function update($object) {
		if (get_class($object) != 'UbaHtmlContentMO') {
			throw new WrongClassException(get_class($object).'->UbaHtmlContentMO');
		}
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);	
		$object = UbaHtmlContentDAO::update($cwrap, $object);
		DBConnection::close($cwrap);

		UbaHtmlContentService::refreshCache();

		return $object;
	}

	static function deleteById($id) {
		$cwrap = DBConnection::open(UbaHtmlContentService::MAP);	
		$object = UbaHtmlContentDAO::deleteById($cwrap, $id);
		DBConnection::close($cwrap);

		UbaHtmlContentService::refreshCache();

		return $object;
	}
}
?>
