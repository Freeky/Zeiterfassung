<?php
	require_once(dirname(__FILE__) . "/../conf/connect_db.inc");
	require_once(dirname(__FILE__) . "/Assignment.php");
	
	class AssignmentConnector {
		
		public function getAssignmentByID($id) {
			if(!is_int($id) or $id <= 0) {
				Throw new Exception("getAssignmentByID hat keine gültige ID erhalten");
			}
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
			$query = "Select id, name, description, employer, creationdate, deadline, status from assignment where 1=1 ";
			
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
				$query = $query."and creationdate >= '".mysql_real_escape_string($minCreationDate->format("Y-m-d"))."' ";
			}
			
			if(!is_null($maxCreationDate)) {
				$query = $query."and creationdate <= '".mysql_real_escape_string($maxCreationDate->format("Y-m-d"))."' ";
			}
			
			$query = $query."and (deadline is NULL or ( 1=1 ";
			
			if(!is_null($minDeadline)) {
				$query = $query."and deadline >= '".mysql_real_escape_string($minDeadline->format("Y-m-d"))."' ";
			}
			
			if(!is_null($maxDeadline)) {
				$query = $query."and deadline <= '".mysql_real_escape_string($maxDeadline->format("Y-m-d"))."' ";
			}
			
			$query = $query.")) ";

			if(!is_null($status)) {
				$query = $query."and ( 1=0 ";
				foreach($status as $s) {
					$query = $query."or status = '".mysql_real_escape_string($s)."' ";
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
				throw new Exception("saveAssignment needs an Argument of type Assignment");
			}
			
			if(is_null($assignment->getName()) or 
			   is_null($assignment->getEmployer()) or 
			   is_null($assignment->getCreationDate()) or
			   is_null($assignment->getStatus())) {
			   	throw new Exception("saveAssignment received an invalid Assignment");
			}
			
			if($assignment->getID() <= 0) {
				// Datensatz anlegen
				$query = "insert into assignment (name, description, employer, creationdate, deadline, status) values (";
				$query = $query."'".mysql_real_escape_string($assignment->getName())."', ";
				if(is_null($assignment->getDescription()))
					$query = $query."NULL, ";
				else 
					$query = $query."'".mysql_real_escape_string($assignment->getDescription())."', ";
					
				$query = $query."'".mysql_real_escape_string($assignment->getEmployer())."', ";
				
				$query = $query."'".mysql_real_escape_string($assignment->getCreationDate()->format("Y-m-d"))."', ";
				
				if(is_null($assignment->getDeadline()))
					$query = $query."NULL, ";
				else 
					$query = $query."'".mysql_real_escape_string($assignment->getDeadline()->format("Y-m-d"))."', ";
				
				$query = $query."'".mysql_real_escape_string($assignment->getStatus())."')";
				
				mysql_query($query);
				
				if(mysql_affected_rows() != 1)
					Throw new Exception("Fehler beim Einfügen der Daten(".mysql_affected_rows()."): ".mysql_error());
			} else {
				// Datensatz updaten
				$query = "update assignment set ";
				$query = $query."name = '".mysql_real_escape_string($assignment->getName())."', ";
				
				if(is_null($assignment->getDescription()))
					$query = $query."description = NULL, ";
				else 
					$query = $query."description = '".mysql_real_escape_string($assignment->getDescription())."', ";
					
				$query = $query."employer = '".mysql_real_escape_string($assignment->getEmployer())."', ";
				
				$query = $query."creationdate = '".mysql_real_escape_string($assignment->getCreationDate()->format("Y-m-d"))."', ";
				
				if(is_null($assignment->getDeadline()))
					$query = $query."deadline = NULL, ";
				else 
					$query = $query."deadline = '".mysql_real_escape_string($assignment->getDeadline()->format("Y-m-d"))."', ";
				
				$query = $query."status = '".mysql_real_escape_string($assignment->getStatus())."' ";
				
				$query = $query."where id = ".$assignment->getID();
				
				mysql_query($query);
				
				if(!(mysql_affected_rows() <= 1) and !(mysql_affected_rows() >= 0))
					Throw new Exception("Fehler beim Einfügen der Daten(".mysql_affected_rows()."): ".mysql_error());
			}
			
			
		}
		
		private function deleteAssignment($id){
			if(!is_int($id) or $id <= 0){
				Throw new Exception("deleteAssignment hat keine gültige ID erhalten");
			}
			
			$id = mysql_escape_string($id);
			$query = "delete from assignment where id = $id;";
			
			mysql_query($query);
			
			if(mysql_affected_rows() != 1) {
				Throw new Exception("Datensatz konnte nicht gelöscht werden");
			}
		}
		
		private function resultToAssignment($result)
		{
			$assignment = new Assignment;
			$assignment->setID($result['id']);
			$assignment->setName($result['name']);
			$assignment->setDescription($result['description']);
			$assignment->setEmployer($result['employer']);
			$assignment->setCreationDate(new DateTime($result['creationdate']));
			if(!is_null($result['deadline']))
				$assignment->setDeadline(new DateTime($result['deadline']));
			$assignment->setStatus($result['status']);
			
			return $assignment;
		}
	}
?>