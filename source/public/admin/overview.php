<?php
	include '../../conf/functions.inc';
	include "../controller/Controller.php";
	$controller = new Controller();
	session_start();
	if($_SESSION['login']!="ok")
	{
		echo '
			<font color="red" face="Helvetica, Arial, sans-serif"><h2>Incorrect Session. You will be redirected to the LogIn-Screen in <span id="counter" class="dd">5</span> seconds.</h2></font><br><meta http-equiv="refresh" content="5; url=http://127.0.0.1/timetraveler/admin/index.php">
			<script type="text/javascript">
			countDown(true);
			function countDown(init)
			{
				if (init || --document.getElementById( "counter" ).firstChild.nodeValue >0 )
				window.setTimeout("countDown()",1000);
			};
			</script>';
	}
	else
	{
		if(isset($_REQUEST['name'])&&isset($_REQUEST['password'])&&isset($_REQUEST['admin']))
		{
			$user=$controller->CreateEmptyUserObject();
			$user->setName($_REQUEST['name']);
			$user->setPassword($_REQUEST['password']);
			$user->setAdmin($_REQUEST['admin']);
			$controller->saveUser($user);
		}
		echo '
			<html>
			<head>
				<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	  			<title>User-Management - LogIn</title>
	 			<style type="text/css">
					.mitte{
						position:absolute;
						width:300px;
						height:400px;
						margin-top: -200px; /* sagt dem DIV, das es vertikal in der mitte stehen soll*/
						margin-left: -150px; /* sagt dem DIV, das es horizonal in der mitte stehen soll*/
						left: 50%;
						top: 50%;
					}
	 			</style>
			</head>

			<body>
				<div class="mitte" id="main" name="main">
					<form action="overview.php" method="get">
						<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">				
							<tr>
								<td height="50%" align="center">
									<img src="../images/timetraveler-logo.jpg" width="350">
									<br>
									<br>
									<font color="black" face="Helvetica, Arial, sans-serif"><strong>User-Management - User Overview</font>
									<br>
								</td>
							</tr>
							<tr>
								<td height="50%" align="right" valign="middle" style="font-size: default;font-family: Helvetica, Arial,  sans-serif;">
									<br>
									<a href="logout.php">Logout</a>
									<br><br>
								</td>
							</tr>
							<tr>
								<td align="center" valign="bottom" style="font-size: xx-small; font-family: Helvetica, Arial,  sans-serif;">
									'.drawOverviewTable().'
								</td>
							</tr>
						</table>
					</form>
				</div>
			</body>
		</html>';
	}

	function drawOverviewTable()
	{
		global $controller;
		
		$editpic="<img src=\"..\images\edit.jpg\" height=\"25\">";
		$deletepic="<img src=\"..\images\x.jpg\" height=\"25\">";
		$users=$controller->getAllUsers();
		$tmp='<table border="0">';
		$tmp.='<tr>';
		$tmp.='<td>UID:</td><td>Username:</td><td>Password:</td><td>Admin:</td><td></td><td></td>';
		$tmp.='</tr>';
		$tmp.='<form action="overview.php" method="GET">';
		$tmp.='<tr>';
		$tmp.='<td>*</td>';
		$tmp.='<td><input type="text" name="name" size="10" maxlength="25"></input></td>';
		$tmp.='<td><input type="password" name="password" size="10" maxlength="25"></input></td>';
		$tmp.='<td><SELECT name="admin"><OPTION VALUE="0">USER</OPTION><OPTION VALUE="1">ADMIN</OPTION></SELECT></td>';
		$tmp.='<td colspan="2"><input class="button" type="submit" value="Create" /></td>';
		$tmp.='</form>';
		$tmp.='</tr>';
		for($i=0;$i<count($users);$i++)
		{
			$uid = $users[$i]->getUID();
			$name = $users[$i]->getName();
			$pw_len = $users[$i]->getPasswordLen();
			$admin = $users[$i]->getAdmin();
			if($admin==1){$admin="ADMIN";}else{$admin="USER";}
			$tmp.='<tr>';
			$tmp.='<td>'.$uid.'</td><td>'.$name.'</td><td>'.Dots($pw_len).'</td><td>'.$admin.'</td><td><a href="http://127.0.0.1/timetraveler2/admin/views/edit.php?uid='.$uid.'">'.$editpic.'</a></td><td><a href="http://127.0.0.1/timetraveler2/admin/views/delete.php?uid='.$uid.'">'.$deletepic.'</a></td>';
			$tmp.='</tr>';
		}
		$tmp.='</table>';
		return $tmp;
	}
?>