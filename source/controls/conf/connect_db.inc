<?php
$db_host='localhost';
$db_name='timetraveler';
$db_user='fugu';
$db_pass='fugu';

$db_link = mysql_connect($db_host, $db_user, $db_pass);
mysql_selectdb($db_name,$db_link);
?>