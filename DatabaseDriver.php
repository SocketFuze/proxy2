<?php

class DatabaseDriver {
	var $handler;

	/**
	 * Opens up the database connection'
	 */
	public function __construct($host, $username, $password, $database) {
		$handler = mysql_connect($host, $username, $password);
		mysql_select_db($database, $handler);
	}

	/**
	 * Inserts the proxy into the database
	 */
	public function insertProxy($ipAddress, $port, $cCode, $cName, $date) {
		$sql = "INSERT INTO proxies VALUES(NULL, '{$ipAddress}', {$port}, '{$cCode}', '{$cName}', '{$date}')";
		mysql_query($sql);
	}

	/**
	 * Collates all rows into an array which can be
	 * manipulated easily
	 */
	public function getProxies() {
		$sql = "SELECT * FROM proxies";
		$retVal = array();

		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)) {
			$retVal[] = $row;
		}
		return $retVal;
	}

	/**
	 * Deletes a record depending on ID field
	 */
	public function deleteProxy($id) {
		$sql = "DELETE FROM proxies WHERE id = {$id}";
		mysql_query($sql);
	}

	/**
	 * Checks if there is a duplicate ip and port
	 * combination
	 */
	public function checkDuplicate($ip, $port) {
		$sql = "SELECT * FROM proxies WHERE IP = '{$ip}' AND PORT = {$port}";
		$result = mysql_query($sql);
		return (mysql_num_rows($result) > 0);
	}
}