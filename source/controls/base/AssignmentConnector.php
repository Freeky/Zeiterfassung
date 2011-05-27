<?php
	require_once '../conf/connect_db.inc';
	require_once 'Assignment.php';
	
	class AssignmentConnector {
		
		public function getAssignmentByID($id) {
			$id = mysql_escape_string($id);
			$query = "Select id, name, description, employer, creationdate, deadline, status from assignment where id = $id;";
			$resource = mysql_query($query);
			
			$result = mysql_fetch_array($resource);
			
			return $this->resultToAssignment($result);
		}
		
		public function searchAssignment($name = NULL, 
										$description = NULL, 
										$employer = NULL, 
										$minCreationDate = NULL, 
										$maxCreationDate = NULL,
										$minDeadline = NULL, 
										$maxDeadline = NULL,
										$status = NULL) {
			
			//evaluate and create query string
			$query = "Select id, name, description, employer, creationdate, deadline, status from assignment where 1=1 "
			
			if(!is_null($name)) {
				$query = $query."and name like '%".mysql_real_escape_string($name)."%' ";
			}
			
			if(!is_null($description)) {
				$query = $query."and description like '%".mysql_real_escape_string($description)."%' ";
			}
			
			if(!is_null($employer)) {
				$query = $query."and employer like '%".mysql_real_escape_string($employer)."%' ";
			}
			
			if(!is_null($minCreationDate)) {
				$query = $query."and creationdate >= '".mysql_real_escape_string($minCreationDate)."' ";
			}
			
			if(!is_null($maxCreationDate)) {
				$query = $query."and creationdate <= '".mysql_real_escape_string($maxCreationDate)."' ";
			}
			
			if(!is_null($minDeadline)) {
				$query = $query."and deadline >= '".mysql_real_escape_string($minDeadline)."' ";
			}
			
			if(!is_null($maxDeadline)) {
				$query = $query."and deadline <= '".mysql_real_escape_string($maxDeadline)."' ";
			}
			
			if(!is_null($status)) {
				$query = $query."and ( 1=0 ";
				foreach($status as $s) {
					$query."or status = '".mysql_real_escape_string($s)."' "
				}
				$query = $query.") ";
			}
			
			//process result
			$resource = mysql_query($query);
			
			$assignments = array();
			
			while($result = mysql_fetch_array($resource)){
				$assignments[] = $this->resultToAssignment($result);
			}
			
			return $assignments;
		}
		
		public function saveAssignment($assignment) {
			
			if(!(get_class($assignment) == "Assignment")) {
				throw new Exception("saveAssignment needs an Argument of type Assignment")
			}
			
			if(is_null($assignment->getName()) or 
			   is_null($assignment->getEmployer()) or 
			   is_null($assignment->getCreationDate()) or
			   is_null($assignment->getStatus())) {
			   	throw new Exception("saveAssignment received an invalid Assignment")
			}
			
			if($assignment->getID() <= 0) {
				// Datensatz anlegen
				$query = "insert into assignment (name, description, employer, creationdate, deadline, status) values ("
			} else {
				// Datensatz updaten
			}
			
			INSERT INTO `timetraveler`.`assignment` (`name`, `descritption`, `employer`, `creationdate`, `deadline`, `status`) VALUES ('Doing Whooop', 'jo', 'no', '27-5-2011', '1-1-2012', 'Planned');
			
		}
		
		private function resultToAssignment($result)
		{
			$assignment = new Assignment;
			$assignment->setID($result['id']);
			$assignment->setName($reslut['name']);
			$assignment->setDescription($result['name']);
			$assignment->setEmployer($result['employer']);
			$assignment->setCreationDate($result['creationdate']);
			$assignment->setDeadline($result['deadline']);
			$assignment->setStatus($result['status']);
			
			return $assignment;
		}
	}
?>