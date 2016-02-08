<?php

/**
 * \brief This class contains Database Connection details
 * \n Features:
 * \li Create Database Object
 * \li Get Database Object
 * \li Close Connection
 * \n
 * \author Sahil Saggar
 * \version 1.0
 * \date 08/11/2011
 * \note (C) 2011 Fermion Infotech Private Limited. All rights reserved. (info@fermion.in)
 */
final class DbConn{

	private static $connections = array(); /**< Array $connections contains Array */

	/**
	 *  _construct don't permit an explicit call of the constructor! (like $v = new Singleton())
	 */
    private function __construct()
    { }

	/**
	 *  _clone don't permit cloning the singleton (like $x = clone $v)
	 */
    private function __clone() { }

	/**
	 *  getDBObject gets connection object to create link with database
	 * @param Array $database contains the details of the database
	 * <p> This function checks that already connected with database or not, otherwise calls createDBObject method to create connection</p>
	 * @return Connection Object.
	 */
	public static function getDBObject($database){
		if(empty(self::$connections[$database])){
			self::$connections[$database] = self::createDBObject($database);
			//self::setTimeZone('Asia/Kolkata', $database);
		}
		return self::$connections[$database];
	}

	public static function setTimeZone($timezone, $database) {
		$query = 'SET time_zone = \'' . $timezone . '\'';
		self::$connections[$database]->query($query);
	}

	/**
	 *  createDBObject creates connection object to create link with database
	 * @param Array $database contains the details of the database
	 * <p> This function create connection with database by using mysqli method</p>
	 * @return Connection Object if successfully connected.
	 */
    private static function createDBObject($database) {
		global $databases;
        try {
			return new mysqli($databases[$database]['host'], $databases[$database]['user'], $databases[$database]['password'], $databases[$database]['database']);
		}
		catch (Exception $err){
			$sysErr = 'Message: ' .$err->getMessage();
			$custErr = 'Error in file: '.__FILE__.', Line: '.__LINE__;
			error_log($sysErr . "\n" . $custErr);
		}
    }

	/**
	 *  closeConnections closes database connection
	 * @param : No parameters
	 * <p> This function closes database connection</p>
	 * @return void
	 */
	public static function closeConnections() {
		try {
			foreach(self::$connections as $connection) {
				try {
					$connection->close();
				} catch(Exception $closeErr) {}
			}
			self::$connections = null;
		} catch(Exception $err) {
			echo $err->getMessage();
		}
	}
}
