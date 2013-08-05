<?php
require_once("ProxyChecker.php");
require_once("DatabaseDriver.php");

$db = new DatabaseDriver("localhost", "socket_user", "1a2a3a4a", "socket_proxy");
$results = $db->getProxies();

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=good.txt");

for($i = 0; $i < count($results); $i++) {
	$ip = $results[$i]['ip'];
	$port = $results[$i]['port'];
	if(ProxyChecker::checkProxy($ip, $port)) {
		echo $ip.",".$port."\n";
	}
}

?>
