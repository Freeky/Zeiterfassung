<?php
	include "../controller/Controller.php";
	$controller = new Controller();
	
	if(isset($_REQUEST['username'])&&isset($_REQUEST['pass']))
	{
			if($controller->checkLogin($_REQUEST['username'], $_REQUEST['pass']))
			{
				session_start();
				$_SESSION['login'] = "ok";
				echo "<meta http-equiv=\"refresh\" content=\"0; url=http://127.0.0.1/timetraveler2/admin/views/overview.php\">";
			}
			else
			{$text="<br>Username/Password/Rights incorrect<br>";}
	}
?>
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
<div class="mitte" id="main">
		<form action="index.php" method="get">
				<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
				
					<tr>
						<td height="50%" align="center">
							<img src="../images/timetraveler-logo.jpg" width="350">
							<br>
							<font color="red" face="Helvetica, Arial, sans-serif"><strong><?php echo $text; ?></strong></font>
							<br>
						</td>
					</tr>
					<tr>
						<td align="center" valign="bottom" style="font-size: default;  font-family: Helvetica, Arial,  sans-serif;">
								Admin-Username:
						</td>
					</tr>
					<tr>
						<td align="center">
							<input name="username" "type="text" size="20" maxlength="20" value="" style="font-size: default">
						</td>
					</tr>
					<tr>
						<td align="center" style="font-size: default;  font-family: Helvetica, Arial,  sans-serif;">
								Password:
						</td>
					</tr>
					<tr>
						<td align="center">
								<input name="pass" type="password" size="20" maxlength="20" style="font-size: default">
						</td>
					</tr>
					<tr>
						<td align="center">
								<br>
								<input name="login" type="submit" size="45" maxlength="20" style="font-size: medium; height: 2.0em;"  value="        Login        ">
						</td>
					</tr>

				
				</table>
				</form>
</div>
</body>
</html>