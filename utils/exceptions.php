<?php

// $e->getMessage()

// Basic Phramework Exception
class PWException extends Exception {
}

// Terminate page
class TerminatePage extends PWException {
}

// Configuration Exception
class ConfigurationException extends PWException {
	public $disableReporting = true;
}

// Login Exceptions
class LoginException extends PWException {
}
class UnconfirmedLoginException extends LoginException {
}

// Form Submissions Exceptions
class FormException extends PWException {
}
class FormValidationException extends FormException {
}

// Class Exceptions
class ClassException extends PWException {
}
class WrongClassException extends ClassException {
}

// IO Exceptions
class IOException extends PWException {
}

// File Exceptions
class FileException extends IOException {
}
class FileDoesNotExistException extends FileException {
}

// Cache Exceptions
class CacheException extends PWException {
}
class CacheExpiredException extends CacheException {
}
class CacheNotSupportedException extends CacheException {
}
class CacheNotSetException extends CacheException {
}

// Database Exceptions
class DatabaseException extends PWException {
}
class DatasourceDoesNotExistException extends DatabaseException {
}
class DatabaseMaxConnectionsReachedException extends DatabaseException {
}
class DatabaseConnectionException extends DatabaseException {
}
class DatabaseRecordNotFoundException extends DatabaseException {
}
class DatabaseRecordCreationException extends DatabaseException {
}
class DatabaseRecordUpdateException extends DatabaseException {
}

// Unit Test Exceptions
class UnitTestException extends PWException {
}

// Mailer Exceptions
class MailerException extends PWException {
}

// Mailer Exceptions
class BypassException extends PWException {
	public $url;
	function __construct($u = "index.php") {
		$url = $u;
	}
}
?>
