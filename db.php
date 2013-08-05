<?php
$mysql_hostname = "localhost";
$mysql_user = "socket_user";
$mysql_password = "1a2a3a4a";
$mysql_database = "socket_proxy";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

?>