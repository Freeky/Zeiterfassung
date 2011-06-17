<?php
$db_host='localhost';
$db_name='timetraveler';
$db_user='fugu';
$db_pass='fugu';

$db_link = mysql_connect($db_host, $db_user, $db_pass);
if (!$db_link) {
    die('keine Verbindung möglich: ' . mysql_error());
}
if(!mysql_select_db($db_name,$db_link))
	die('keine Datenbank ausgewählt: ' . mysql_error());
?>