<?php

require_once("ProxyChecker.php");
require_once("DatabaseDriver.php");

// if(!isset($_POST)) exit(); //TODO change to post

// Last Checked Tab Vars
$date = date('m/d/Y h:i:s a', time());

$ipAddress = $_POST['ipaddress'];

if (isset($ipAddress)) {
	echo nl2br($ipAddress);
	echo "<br />";
	$ips = explode("\n", trim($ipAddress));
	foreach($ips as $ip) {
		$tmp = explode(":", $ip);
		$ip = trim($tmp[0]);
		$port = trim($tmp[1]);
		if(ProxyChecker::checkProxy($ip, $port)) {
			$loc = ProxyChecker::getLocation($ipAddress); 
			$ipAddress = mysql_escape_string($ipAddress); //FIXME: Update to MySQLi
			$port = mysql_escape_string($port);
	
			$db = new DatabaseDriver("localhost", "socket_user", "1a2a3a4a", "socket_proxy");
			if(!$db->checkDuplicate($ip, $port)) {
				$db->insertProxy($ip, $port, $loc["countryCode"], $loc["countryName"], $date);
				echo "<br /> Added: {$ip}:{$port} ~successfuly";
				//header('Location: http://socketfuze.net/');
			} else {
				echo "<br /> Duplicate: {$ip}:{$port} ~found in the database";
			}
		} else {
			echo "<br /> Proxy Dead: {$ip}:{$port}";
		}
	}
}

?>

<!-- The form inputs needed -->