<?php
/**
 * Proxy Checker
 * Written by Sambuca
 * I take no liability for how this script
 * is being run
 */

class ProxyChecker {
	/*
	 * The URL to get to through the proxy server
	 */
	public static $url = "http://www.google.com";

	/**
	 * Checks the status of the proxy
	 * @arg ipaddress the ip address of the proxt server
	 * @arg port the port of the proxy default 80
	 * @arg proxtType proxy, SOCKS4 or SOCKS5, default proxy
	 * @return true if the proxy works, false otherwise
	 */
	public static function checkProxy($ipaddress, $port = 80, $proxyType = "proxy") {
		$retVal = "";
		if(strlen($ipaddress) < 1) {
			return false;
		} else {
			$ch = curl_init(self::$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  	curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_PROXY, "{$ipaddress}:{$port}");

			if(strtoupper($proxyType) == "SOCKS4") {
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
			} elseif(strtoupper($proxtType) == "SOCKS5") {
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
			}

			$html = curl_exec($ch);

			if(curl_errno($ch) || $html == "") {
				return true;
			} else {
				return false;
			}
		}

	}
	
	/**
	 * Gets the location of the server through its IP address
	 * @arg ipaddress the ip address of the proxy server
	 * @returns array(countryCode, countryName)
	 */
	public static function getLocation($ipaddress) {
		$data = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip={$ipaddress}"));
		$retval = array();
		$retval["countryCode"] = $data["geoplugin_countryCode"];
		$retval["countryName"] = $data["geoplugin_countryName"];
		return $retval;
	}
}
?>
