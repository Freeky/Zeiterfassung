<?php
	class Assignment {
		
		private $id = -1;
		private $name = NULL;
		private $description = NULL;
		private $employer = NULL;
		private $creationDate = NULL;
		private $deadline = NULL;
		private $status = NULL;
		
		public function setID($id) { 
			if($id < 0) Throw new Exception("received negativ id");
			$this->id = $id; 
		}
		
		public function setName($name) { 
			if($name == NULL or $name == "") Throw new Exception("received empty name");
			$this->name = $name; 
		}
		
		public function setDescription($descr) { 
			$this->description = $descr; 
		}
		
		public function setEmployer($employer){ 
			if($employer == NULL or $employer == "") Throw new Exception("received empty employer");
			$this->employer = $employer; 
		}
		
		public function setCreationDate($date) { 
			$this->creationDate = $date; 
		}
		
		public function setDeadline($date) { 
			$this->deadline = $date; 
		}
		
		public function setStatus($status) { 
			$status = ucwords(strtolower($status));
			if($status != "Done" and 
			   $status != "Planned" and 
			   $status != "In Progress" and 
			   $status != "Canceled")
				Throw new Exception("received unvalid status");
			$this->status = $status; 
		}
		
		public function getID() { return $this->id; }
		public function getName() { return $this->name; }
		public function getDescription() { return $this->description; }
		public function getEmployer() { return $this->employer; }
		public function getCreationDate() { return $this->creationDate; }
		public function getDeadline() { return $this->deadline; }
		public function getStatus() { return $this->status; }
	}
?>