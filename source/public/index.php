<?php
require_once(dirname(__FILE__) . "/../controls/admin/Controller.php");

session_start();

$controller = new Controller();

if(isset($_REQUEST['username'])&&isset($_REQUEST['pass']))
{
	if($controller->checkNonAdminLogin($_REQUEST['username'], $_REQUEST['pass']))
	{
		$_SESSION['user'] = $controller->getUserByName($_REQUEST['username']);
		header('Location: overview.php');
	}
	else
	{
		echo "<center><font color=\"red\">Username or Password incorrect</font></center>";
	}
}
?>
<html>
<head>
<title>Zeiterfassung</title>
<link href="./css/screen.css" media="screen" rel="stylesheet"
	type="text/css" />
</head>
<body>
	<div align="center">
		<img src="images/timetraveler-logo.jpg" width="350"><br /> <br />
		<form action="index.php" method="post">
			Benutzername:<br /> <input name="username" "type="text" size="20"
				maxlength="20" value="" /><br /> Passwort:<br /> <input name="pass"
				type="password" size="20" maxlength="20" /><br /> <input
				name="login" type="submit" value="Anmelden">
		</form>
	</div>
</body>
</html>
