<?php

require_once("ProxyChecker.php");
require_once("DatabaseDriver.php");

// if(!isset($_POST)) exit(); //TODO change to post

// Last Checked Tab Vars
$date = date('m/d/Y h:i:s a', time());

$trow = '<td><img src="http://api.find-ip.net/flags/us.png" alt="(US)" style="display:none;"></td><td style="text-align:center;">~IP~</td><td style="text-align:center;">~PORT~</td><td style="text-align:center;">~STATUS~</td><td style="text-align:center">~LOCATION~</td>'; //Result table row template

$ipAddress = $_POST['ipaddress'];

if (isset($ipAddress)) //Get Individual IP address
{

  	$tmp = explode(":", $ipAddress);
		$ip = trim($tmp[0]);
		$port = trim($tmp[1]);
		if(ProxyChecker::checkProxy($ip, $port))
		{
			$loc = ProxyChecker::getLocation($ipAddress); 
			$ipAddress = mysql_escape_string($ipAddress); //FIXME: Update to MySQLi
			$port = mysql_escape_string($port);
	
			$db = new DatabaseDriver("localhost", "socket_user", "1a2a3a4a", "socket_proxy");
			if(!$db->checkDuplicate($ip, $port))
			{
				$db->insertProxy($ip, $port, $loc["countryCode"], $loc["countryName"], $date);
				$status = 'Active';
				//header('Location: http://socketfuze.net/');
			}
			else
			{
				
				$status = 'Active';//'Duplicated';
			}
			
			$status = 'Active';
	
		}
		else
		{
			$status = 'Dead';
		}
		
		$placeholders = array("~IP~","~PORT~","~STATUS~","~LOCATION~");
		$replaces = array($ip,$port,$status,$loc['countryName']);

		echo "$ip:$port###".str_replace($placeholders,$replaces,$trow);//Dumps output

}

?>
