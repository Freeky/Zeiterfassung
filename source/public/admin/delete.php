<?php
	require_once(dirname(__FILE__) . "/../../controls/conf/functions.inc");
	require_once(dirname(__FILE__) . "/../../controls/admin/Controller.php");
	$controller = new Controller();
	session_start();
	if($_SESSION['login']!="ok")
	{
		echo '
			<font color="red" face="Helvetica, Arial, sans-serif"><h2>Incorrect Session. You will be redirected to the LogIn-Screen in <span id="counter" class="dd">5</span> seconds.</h2></font><br><meta http-equiv="refresh" content="5; url=index.php">
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
		if($admin){$admin="admin";}else{$admin="user";}
		
		if(isset($_REQUEST['delete'])|| isset($_REQUEST['cancel']))
		{
			if(isset($_REQUEST['delete']))
			{
				$controller->deleteUser($user);
			}
			echo "<meta http-equiv=\"refresh\" content=\"0; url=overview.php\">";
		}
		
		echo '
			<html>
			<head>
  				<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  				<title>User-Management - Deleting User</title>
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
					<form action="delete.php" method="get">
						<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td height="50%" align="center" colspan="2">
									<img src="../images/timetraveler-logo.jpg" width="350">
									<br>
									<br>
									<font color="green" face="Helvetica, Arial, sans-serif"><strong>User-Management - Deleting User</font>
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
								<td align="right"><input type="text" name="name" size="34" maxlength="20" readonly="readonly" style="background-color:silver" value="'.$name.'"></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">Password:</td>							
								<td align="right"><input type="password" name="pass" size="34" maxlength="20" readonly="readonly" style="background-color:silver" value="'.Dots($pwlen).'" onfocus=\'this.value="";this.form.isChanged.value = true;\'></input><input type="text" name="isChanged" size="34" maxlength="20" value="false" hidden="hidden"></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">validate:</td>							
								<td align="right"><input type="password" name="pass2" size="34" maxlength="20" readonly="readonly" style="background-color:silver" value="'.Dots($pwlen).'" onfocus=\'this.value=""\'></input></td>
							</tr>
							<tr>
								<td style="font-family: Arial, Helvetica, sans-serif;width: 85px" align="right">Type:</td>
								<td align="right"><input type="text" name="admin" size="34" maxlength="20" readonly="readonly" style="background-color:silver" value="'.$admin.'"></input></td>
							</tr>
							<tr>
								<td align="center" style="width: 10%" colspan="2">
									<br>
										<input name="delete" type="submit" size="33" maxlength="20" style="font-size: medium;"  value="   Delete   " >
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
