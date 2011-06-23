<?php
	require_once(dirname(__FILE__) . "/User.php");
	require_once(dirname(__FILE__) . "/../conf/connect_db.inc");

	class Controller
	{
		function checkLogin($name,$pass)
		{
			$SQLResult=mysql_query("SELECT password FROM user WHERE user='$name' AND admin='1'");
			if(($SQLResult != false) and (mysql_num_rows($SQLResult)>0))
			{
				$ScanRow=mysql_fetch_array($SQLResult);
				if(hash("sha512",$pass)==$ScanRow['password']){return true;}else{return false;}
			}else{return false;}
		}
		
		function checkNonAdminLogin($name,$pass)
		{
			$SQLResult=mysql_query("SELECT password FROM user WHERE user='$name'");
			if(($SQLResult != false) and (mysql_num_rows($SQLResult)>0))
			{
				$ScanRow=mysql_fetch_array($SQLResult);
				if(hash("sha512",$pass)==$ScanRow['password']){
					return true;
				}else{
					return false;
				}
			}else{return false;}
		}
		
		function getAllUsers()
		{
			$user=array();
			$SQLResult=mysql_query("SELECT uid FROM user");
			while($ScanRow=mysql_fetch_array($SQLResult))
			{
				$user[]=$this->CreateUserObject($ScanRow['uid']);
			}
			return $user;
		}
		
		function saveUser($user)
		{
			if($user->getUID()==0)
			{
				//User besteht noch nicht
				$name=$user->getName();
				$pass=$user->getPassword();
				$passlen=$user->getPasswordLen();
				$admin=$user->getAdmin();
				$SQLResult=mysql_query("INSERT INTO user(user,password,pw_len,admin) VALUES ('$name','$pass','$passlen','$admin')");
				return true;
			}
			else
			{
				if($this->checkUserNameAlreadyExists($user->getName(),$user->getUID()))
				{
					//Username bereits vorhanden
					return false;
				}
				else
				{
					$uid=$user->getUID();
					$name=$user->getName();
					$pass=$user->getPassword();
					$passlen=$user->getPasswordLen();
					$admin=$user->getAdmin();
					$SQLResult=mysql_query("UPDATE user SET user='$name',password='$pass',pw_len='$passlen',admin='$admin' WHERE uid='$uid'");
					return true;
				}
				
			}
		}
		
		function checkUserNameAlreadyExists($name,$uid)
		{
			$SQLResult=mysql_query("SELECT * FROM user WHERE user='$name' AND uid!='$uid'");
			return mysql_num_rows($SQLResult)>0;
		}
		
		function deleteUser($user)
		{
			$uid=$user->getUID();
			mysql_query("DELETE FROM user WHERE uid='$uid'");
		}
		
		function CreateUserObject($uid)
		{
			$SQLResult=mysql_query("SELECT uid,user,password,pw_len,admin FROM user WHERE uid='$uid'");
			$ScanRow=mysql_fetch_array($SQLResult);
			$uid=$ScanRow['uid'];
			$name=$ScanRow['user'];
			$pass=$ScanRow['password'];
			$passlen=$ScanRow['pw_len'];
			$admin=$ScanRow['admin'];
			
			
			$tmp = new User();
			$tmp->setUID($uid);
			$tmp->setName($name);
			$tmp->setPasswordHash($pass);
			$tmp->setPasswordLen($passlen);
			$tmp->setAdmin($admin);
			return $tmp;
		}
		
		function CreateEmptyUserObject()
		{
			return new User();
		}
		
		function getUserByName($name)
		{
			$SQLResult=mysql_query("SELECT uid FROM user WHERE user='$name'");
			$ScanRow=mysql_fetch_array($SQLResult);
			return $this->CreateUserObject($ScanRow['uid']);
		}
	}
?>