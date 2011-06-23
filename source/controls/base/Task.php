<?php
	class Task {
		
		private $id = -1;
		private $assignmentRef = NULL;
		private $userRef = NULL;
		private $name = NULL;
		private $description = NULL;
		private $starttime = NULL;
		private $endtime = NULL;
		private $status = NULL;
		
		public function setID($id) { 
			if($id < 0) Throw new Exception("received negativ id");
			$this->id = $id; 
		}
		
		public function setAssignmentRef($ref) { 
			if($ref < 0) Throw new Exception("received negativ assignment ref");
			$this->assignmentRef = $ref; 
		}
		
		public function setUserRef($ref) { 
			if($ref < 0) Throw new Exception("received negativ user ref");
			$this->userRef = $ref; 
		} 
		
		public function setName($name) { 
			if($name == NULL or $name == "") Throw new Exception("received empty name");
			$this->name = $name; 
		}
		
		public function setDescription($descr) { 
			$this->description = $descr; 
		}
		
		public function setStarttime($date) { 
			$this->starttime = $date; 
		}
		
		public function setEndtime($date) { 
			$this->endtime = $date; 
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
		public function getAssignmentRef() { return $this->assignmentRef; }
		public function getUserRef() { return $this->userRef; }
		public function getName() { return $this->name; }
		public function getDescription() { return $this->description; }
		public function getStarttime() { return $this->starttime; }
		public function getEndtime() { return $this->endtime; }
		public function getStatus() { return $this->status; }
	}
?>