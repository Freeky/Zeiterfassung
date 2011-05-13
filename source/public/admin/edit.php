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
		$uid=$_REQUEST['uid'];
		$user=$controller->CreateUserObject($uid);
		$uid=$user->getUID();
		$name=$user->getName();
		$pwlen=$user->getPasswordLen();
		$admin=$user->getAdmin();
		if($admin==1){
			$selAdmin='<input type="radio" name="admin" value="1" checked>Admin&nbsp&nbsp;&nbsp;<input type="radio" name="admin" value="0">User';
		}
		else
		{
			$selAdmin='<input type="radio" name="admin" value="1">Admin&nbsp;&nbsp;&nbsp;<input type="radio" name="admin" value="0" checked>User';
		}
		
		if(isset($_REQUEST['change'])|| isset($_REQUEST['cancel']))
		{
			if(isset($_REQUEST['change']))
			{
				$uid=$_REQUEST['uid'];
				$newname=$_REQUEST['name'];
				$newpass=$_REQUEST['pass'];
				$newpass2=$_REQUEST['pass2'];
				$passChanged=$_REQUEST['isChanged'];
				$newadmin=$_REQUEST['admin'];
				if($controller->checkUserNameAlreadyExists($newname,$uid))
				{
					echo "<script language=\"javascript\">
					alert('ERROR: Username already exists');
					history.back();
					</script>";
				}
				else
				{
					$user->setName($newname);
					$user->setAdmin($newadmin);
					if($passChanged)
					{
						if($pass==$pass2)
						{
							$user->setPassword($newpass);		
						}
						else
						{
							echo "<script language=\"javascript\">
							alert('ERROR: Password and validate are not equal');
							history.back();
							</script>";
						}	
					}
				}
				$controller->saveUser($user);
			
			}
		echo "<meta http-equiv=\"refresh\" content=\"0; url=http://127.0.0.1/timetraveler2/admin/views/overview.php\">";
	}
	echo '
			<html>
			<head>
  				<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  				<title>User-Management - Editing User</title>
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
					<form action="edit.php" method="get">
						<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td height="50%" align="center" colspan="2">
									<img src="../images/timetraveler-logo.jpg" width="350">
									<br>
									<br>
									<font color="green" face="Helvetica, Arial, sans-serif"><strong>User-Management - Editing User</font>
									<br>
								</td>
							</tr>
							<tr>
								<td height="50%" align="right" valign="middle" style="font-size: default;font-family: Helvetica, Arial,  sans-serif;" colspan="2">
									<br>
									<a href="logout.php">Logout</a>
									<br><br>
									</td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">UID:</span></td>
								<td align="right"><input type="text" name="uid" size="34" maxlength="25" readonly="readonly" style="background-color:silver" value="'.$uid.'"></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">Username:</td>
								<td align="right"><input type="text" name="name" size="34" maxlength="20" value="'.$name.'"></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">Password:</td>							
								<td align="right"><input type="password" name="pass" size="34" maxlength="20" value="'.Dots($pwlen).'" onfocus=\'this.value="";this.form.pass2.value = "";this.form.isChanged.value = true;\'></input><input type="text" name="isChanged" size="34" maxlength="20" value="false" hidden="hidden"></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">validate:</td>							
								<td align="right"><input type="password" name="pass2" size="34" maxlength="20" value="'.Dots($pwlen).'" onfocus=\'this.value=""\'></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">Type:</td>
								<td>&nbsp'.$selAdmin.'</td>
							</tr>
							<tr>
								<td align="center" style="width: 10%" colspan="2">
									<br>
										<input name="change" type="submit" size="33" maxlength="20" style="font-size: medium;"  value="   Save   " >
										&nbsp&nbsp&nbsp
										<input name="cancel" type="submit" size="33" maxlength="20" style="font-size: medium;"  value="   Cancel   ">
								</td>
							</tr>
				
						</table>
					</form>
				</div>
			</body>
		</html>
	';
}
	
?>
