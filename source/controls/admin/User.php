<?php
	class User
	{
		private $controller;
		private $uid;
		private $name;
		private $pw;
		private $pwlen;
		private $admin;
		
		public function getUID(){return $this->uid;}
		public function getName(){return $this->name;}
		public function getPassword(){return $this->pw;}
		public function getAdmin(){return $this->admin;}
		public function getPasswordLen(){return $this->pwlen;}
		public function setUID($uid){$this->uid=$uid;}
		public function setName($name){$this->name=$name;}
		public function setPassword($pass){$this->pwlen=strlen($pass);$this->pw=hash("sha512",$pass);}
		public function setPasswordHash($pass){$this->pw=$pass;}
		public function setPasswordLen($len){$this->pwlen=$len;}
		public function setAdmin($admin){$this->admin=$admin;}
	}
?>